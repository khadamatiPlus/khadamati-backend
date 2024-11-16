<?php

namespace App\Domains\Delivery\Http\Controllers;

use App\Domains\Captain\Models\Captain;
use App\Domains\Delivery\Http\Transformers\RecentTransformer;
use App\Domains\Delivery\Models\Recent;
use App\Enums\Core\CaptainStatuses;
use App\Enums\Core\OrderStatuses;
use Laravel\Sanctum\PersonalAccessToken;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 7/27/2023
 * Class: AsyncWebSocketController.php
 */
class AsyncWebSocketController implements MessageComponentInterface
{

    protected $clients;
    protected $users;
    protected $subscribers_locations;
    protected $customers;
    protected $pending_requests = [];

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
        $this->subscribers_locations = [];
        $this->customers = [];
    }

    public function checkPendingRequests()
    {
        \Log::notice("\n SIZE OF pending: ".sizeof($this->pending_requests)."\n");
        foreach ($this->pending_requests as $key => &$pending_request)
        {
            $requestID = $key;
            $requestMinutesAge = (time() - $pending_request['delivery_requested_at']) / 60;
            \Log::notice("\n Delivery Request: ".$key." Age in minutes:(".$requestMinutesAge.") \n");
            \Log::notice("\n Order ID: (".$pending_request['order_id'].") \n");
            $order = $this->getOrderById($pending_request['order_id']);
            if(!empty($order->captain_accepted_at)){
                unset($this->pending_requests[$requestID]);
                continue;
            }
            if($requestMinutesAge >= getSettingByKey('delivery_request_age_in_minutes')
                && empty($order->captain_accepted_at)){
                \Log::alert("\n Delivery Request: ".$key." will be re-requested "."Age in minutes:(".$requestMinutesAge.") \n");
                \Log::alert("\n pending Captains count: ".sizeof($pending_request['requested_captains'])."\n");
                foreach ($pending_request['requested_captains'] as &$captain)
                {
                    if(isset($this->subscribers_locations[$captain['user']->id]['request_group_id'])){
                        if($this->subscribers_locations[$captain['user']->id]['request_group_id'] == $pending_request['request_group_id']
                            && $this->subscribers_locations[$captain['user']->id]['status'] != CaptainStatuses::PENDING_REQUEST)
                        {
                            \Log::alert("\n captain request id matched the request group id\n");
                            $this->subscribers_locations[$captain['user']->id]['status'] = CaptainStatuses::ONLINE;
                            unset($this->subscribers_locations[$captain['user']->id]['request_group_id']);
                        }
                    }
                    else{
                        \Log::alert("\n ERROR ERROR ERROR ERROR Request group id not matched with captains \n");
                    }
                }
                unset($this->pending_requests[$requestID]);
                $this->sendDeliveryRequest($order->id,((int)$pending_request['retry_number'] + 1));
            }
        }
    }

    /**
     * [onOpen description]
     * @method onOpen
     * @param  ConnectionInterface $conn [description]
     * @return [JSON]                    [description]
     * @example connection               var conn = new WebSocket('ws://localhost:8090');
     */
    public function onOpen(ConnectionInterface $conn)
    {
        \Log::notice("new conn\n");
        //get query params to fetch access token
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $res);
        //check if token exist in query params
        if (isset($res['access_token'])) {
            //we need to get the auth user by token
            $conn->accessToken = $res['access_token'];
            $user = $this->getUserByToken($res['access_token']);
            \Log::notice("\n connection established ".$conn->accessToken);
            if(!is_null($user)){
                $this->clients->attach($conn);
                $this->users[$conn->accessToken] = $conn;
//                $user->update([
//                   'points' => 0
//                ]);
                //captain
                if($user->isCaptain() && !empty($user->captain_id))
                {
                    if($user->captain->is_verified != 1){
                        $conn->send(json_encode(['type' => 403,'data' => ['message' => __('Your captain profile should be verified by :app_name Administrator',['app_name' => appName()])]]));
                        $conn->close();
                    }
                    if($user->captain->is_paused == 1){
                        $conn->send(json_encode(['type' => 405,'data' => ['message' => __('Your captain profile is paused please contact :your_company',['your_company' => env('DELIVERY_COMPANY') ?? appName()])]]));
                        $conn->close();
                    }
                    //UPDATE captain status to online
                    $this->updateCaptain($user->id,[
                        'status' => CaptainStatuses::ONLINE
                    ]);
                    $conn->type = 'captain';
                    $user->conn = $conn;
                    $this->updateSubscriberLocation($user);

                    $this->handleCurrentTrip($conn,$user);
                }
                //customer
                elseif($user->isCustomer() && !empty($user->customer_id)){
                    if(isset($res['order_id'])){
                        if(!$this->isPendingOrder($res['order_id'],$user->customer_id)){
                            $conn->send(json_encode(['type' => 401, 'data' => ['message' => __('You don\'t have any pending order to track')]]));
                            $conn->close();
                        }
                        //subscribe the customer to order route
                        else{
                            $user->conn = $conn;
                            $conn->type = 'customer';
                            $this->customers[$user->customer_id] = $user;
                            $order = $this->getOrderById($res['order_id']);
                            $conn->send(json_encode(['type' => 1, 'data' => ['message' => __('You were successfully subscribed to your order tracking')]]));
                            $this->updateOrderTracking($res['order_id'],$this->subscribers_locations[$order->captain_id]['lat'],$this->subscribers_locations[$order->captain_id]['long']);
                        }
                    }
                    else{
                        $conn->send(json_encode(['type' => 401, 'data' => ['message' => __('Missing order_id')]]));
                        $conn->close();
                    }
                }
                else{
                    $conn->send(json_encode(['type' => 401,'data' => ['message' => __('Unauthorized access')]]));
                    $conn->close();
                }
            }
            else{
                $conn->send(json_encode(['type' => 401,'data' => ['message' => __('Unauthorized access')]]));
                $conn->close();
            }
        }
        //handle redis server connection
        elseif (isset($res['dispatcher_token'])){
            $conn->dispatcher_token = $res['dispatcher_token'];
            $this->verifyDispatcherConn($conn);
            $this->clients->attach($conn);
        }
        else {
            $conn->close();
        }
    }

    /**
     * [onMessage description]
     * @method onMessage
     * @param  ConnectionInterface $conn [description]
     * @param  [JSON.stringify]              $msg  [description]
     * @return [JSON]                    [description]
     */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        $data = json_decode($msg);

        if(isset($conn->accessToken)){
            $user = $this->getUserByToken($conn->accessToken);
            if(is_null($user) || !$user->isCaptain()){
                $conn->send(json_encode(['type' => 401,'data' => ['message' => __('Unauthorized access')]]));
                $conn->close();
            }
            if($user->captain->is_verified != 1){
                $conn->send(json_encode(['type' => 403,'data' => ['message' => __('Your captain profile should be verified by :app_name Administrator',['app_name' => appName()])]]));
                $conn->close();
            }
            if($user->captain->is_paused == 1){
                $conn->send(json_encode(['type' => 405,'data' => ['message' => __('Your captain profile is paused please contact :your_company',['your_company' => env('DELIVERY_COMPANY') ?? appName()])]]));
                $conn->close();
            }
            $user->conn = $conn;
            //handle captain commands
            if (isset($data->command)) {
                switch ($data->command) {
                    case 'update_cap_location':

                        //update captain location here
                        $this->updateCaptain($user->id,[
                            'latitude' => $data->lat,
                            'longitude' => $data->long
                        ]);
                        $this->updateSubscriberLocation($user,$data->lat,$data->long,$this->subscribers_locations[$user->id]['status'],$this->subscribers_locations[$user->id]);

                        /*
                         * the below increment just to be sure that location is being updated
                         * for Development only
                         */
//                        $user->increment('points');
                        $conn->send(json_encode(['type' => 1, 'data' => ['message' => "location updated successfully"]]));
                        break;
                    case 'accept_request':
                        $order = $this->getOrderById($data->order_id);
                        if(empty($order->captain_accepted_at) && empty($order->captain_id)){
                            $order = $order->acceptByCaptain($user->id);
                            $conn->send(json_encode(['type' => 3, 'data' => ['accepted' => true, 'order' => (new RecentTransformer)->transformForSocket($order)]]));
                            $this->updateCaptain($user->id,[
                                'status' => CaptainStatuses::BUSY
                            ]);
                            \Log::notice("\n accepted group id ".$data->request_group_id."\n");
                            unset($this->pending_requests[$data->request_group_id]);
//                            \Log::notice("\n SIZE OF AFTER ACCEPT: ".sizeof($this->pending_requests)." \n";
                            //loop through other captains whose requested to the same order and hide the dialog'
                            foreach ($this->subscribers_locations as $id => &$subscribers_location)
                            {
                                if(isset($this->subscribers_locations[$user->id]['request_group_id'])
                                    && isset($subscribers_location['request_group_id'])){
                                    if($id != $user->id
                                        && $this->subscribers_locations[$user->id]['request_group_id'] == $subscribers_location['request_group_id']
                                    ){
                                        //send hide request
                                        $subscribers_location['status'] = CaptainStatuses::ONLINE;
                                        $subscribers_location['user']->conn->send(json_encode(['type' => 5, 'data' => ['message' => __('Another Captain has accepted the order'), 'order' => (new RecentTransformer)->transformForSocket($order), 'request_group_id' => $subscribers_location['request_group_id'] ?? '']]));
                                        unset($subscribers_location['request_group_id']);
                                    }
                                }
                            }
                            $this->updateOrderTracking($order->id,$this->subscribers_locations[$order->captain_id]['lat'],$this->subscribers_locations[$order->captain_id]['long']);
                        }
                        else{
                            $conn->send(json_encode(['type' => 5, 'data' => ['message' => __('Another Captain has accepted the order'), 'order' => (new RecentTransformer)->transformForSocket($order), 'request_group_id' => $this->subscribers_locations[$user->id]['request_group_id'] ?? '']]));
                        }
                        break;
                    case 'reject_request':
                        $this->updateCaptain($user->id,[
                            'status' => CaptainStatuses::ONLINE
                        ]);
                        unset($this->subscribers_locations[$user->id]['request_group_id']);

                        $conn->send(json_encode(['type' => 4, 'data' => ['rejected' => true]]));
                        break;
                    case 'cancel_order':
                        if(isset($data->order_id)){
                            $order = $this->getOrderById($data->order_id);
                            if(!empty($order->captain_accepted_at)
                                && empty($order->captain_arrived_at)
                                && empty($order->captain_started_trip_at)
                                && $order->captain_id == $user->id)
                            {
                                $order->fill([
                                    'cancelled_at' => now(),
                                    'cancelled_by_id' => $user->id,
                                    'status' => OrderStatuses::CAPTAIN_CANCELLED
                                ])->save();
                                $this->updateCaptain($user->id,[
                                    'status' => CaptainStatuses::ONLINE
                                ]);
                                $order->refresh();
                                $order = (new RecentTransformer)->transformForSocket($order);
                                $conn->send(json_encode(['type' => 9, 'data' => ['order' => $order]]));
                            }
                            else{
                                $conn->send(json_encode(['type' => 11, 'data' => ['message' => __('You cannot cancel the order at this time')]]));
                                $conn->send(json_encode(['type' => 6, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order)]]));
                            }
                        }
                        break;
                    case 'confirm_order_pickup':

                        $order = $this->getOrderById($data->order_id);
                        if(!empty($order->captain_arrived_at)
                            && empty($order->captain_picked_order_at)
                            && $order->captain_id == $user->id){
                            $order = $order->confirmCaptainPickup();
                            $conn->send(json_encode(['type' => 6, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order)]]));
                        }
                        else{
                            $conn->close();
                        }
                        break;
                    case 'start_trip':

                        if(isset($data->order_id)){

                            $order = $this->getOrderById($data->order_id);
                            echo 'captain_accepted_at:'. $order->captain_accepted_at;
                            echo 'captain_arrived_at:'. $order->captain_arrived_at;
                            echo 'captain_picked_order_at:'. $order->captain_picked_order_at;
                            echo 'captain_started_trip_at:'. $order->captain_started_trip_at;
                            echo 'ids:'. $order->captain_id .$user->id ;

                            if(!empty($order->captain_accepted_at)

                                && !empty($order->captain_arrived_at)
                                && !empty($order->captain_picked_order_at)
                                && empty($order->captain_started_trip_at)
                                && $order->captain_id == $user->id)
                            {
                                echo 'captain_accepted_at:'.$order->captain_accepted_at;
                                $order = $order->captainStartTripToCustomer();
                                //init order tracking
                                $this->updateOrderTracking($order->id,$this->subscribers_locations[$user->id]['lat'],$this->subscribers_locations[$user->id]['long']);
                                //show confirm arrive customer dialog
                                $conn->send(json_encode(['type' => 7, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order)]]));
                            }
                            else{
                                $conn->close();
                            }
                        }
                        break;
                    case 'arrive_customer':
                        if(isset($data->order_id)){
                            $order = $this->getOrderById($data->order_id);
                            if(!empty($order->captain_accepted_at)
                                && !empty($order->captain_arrived_at)
                                && !empty($order->captain_picked_order_at)
                                && !empty($order->captain_started_trip_at)
                                && empty($order->delivered_at)
                                && $order->captain_id == $user->id)
                            {
                                $order->confirmCaptainArriveCustomer();
                                $this->updateCaptain($user->id,[
                                    'status' => CaptainStatuses::ONLINE
                                ]);
                                //send update to customer to close socket
                                if(isset($this->customers[$order->customer_id])){
                                    $this->customers[$order->customer_id]->conn
                                        ->send(json_encode(['type' => 3,'data' => ['order' => (new RecentTransformer)->transformForCustomer($order),'message' => __('Your order has been arrived to your location')]]));
                                    $this->customers[$order->customer_id]->conn->close();
                                }
                                //remove pending order
                                unset($this->subscribers_locations[$user->id]['pending_order']);
                                $conn->send(json_encode(['type' => 8, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order)]]));
                            }
                            else{
                                $this->updateCaptain($user->id,[
                                    'status' => CaptainStatuses::ONLINE
                                ]);
                                $conn->send(json_encode(['type' => 8, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order)]]));
                            }
                        }
                        break;
                    case 'check_status':
                        if($this->subscribers_locations[$user->id]['status'] == CaptainStatuses::BUSY){
                            $conn->send(json_encode(['type' => 10, 'data' => ['is_in_trip' => true]]));
                        }
                        else {
                            $pendingCaptainOrderCount = Recent::query()
                                ->where('captain_id', '=', $user->id)
                                ->whereIn('status', [OrderStatuses::ON_THE_WAY_TO_CUSTOMER, OrderStatuses::CAPTAIN_ACCEPTED])
                                ->count();
                            if ($pendingCaptainOrderCount > 0)
                            {
                                $conn->send(json_encode(['type' => 10, 'data' => ['is_in_trip' => true]]));
                            }
                            else{
                                $conn->send(json_encode(['type' => 10, 'data' => ['is_in_trip' => false]]));
                            }
                        }
                        break;
                    case 'check_in_resume':
                        $this->handleCurrentTrip($conn,$user);
                        break;
                    default:
                        $example = array(
                            'commands' => [
                                "update_cap_location" => '{command: "update_cap_location", lat: "latitude", long: "longitude"}',
                                "accept_request" => '{command: "accept_request", order_id:6}',
                                "reject_request" => '{command: "reject_request", order_id:6}',
                                "confirm_order_pickup" => '{command:"confirm_order_pickup", order_id:6}',
                                "start_trip" => '{command:"start_trip", order_id:6}',
                                "arrive_customer" => '{command:"arrive_customer", order_id:6}',
                                "cancel_order" => '{command:"cancel_order", order_id:6}',
                                "check_status" => '{command:"check_status"}'
                            ],
                            'expected_messages_from_server' => [
                                "update_cap_location" => ['type' => 1, 'data' => ['message' => "location updated successfully"]],
                                "delivery_request" => ['type' => 2, 'data' => ['order' => ['id' => 1], 'distance' => 5, 'request_group_id' => '6-45678776654']],
                                "accept" => ['type' => 3, 'accepted' => true],
                                "reject" => ['type' => 4, 'rejected' => true],
                                "hide_request" => ['type' => 5, 'data' => ['order' => ['id' => 1], 'request_group_id' => '6-54464565']],
                                "show_start_trip" => ['type' => 6, 'data' => ['order' => ['id' => 1]]],
                                "start_trip_response" => ['type' => 7, 'data' => ['order' => ['id' => 1]]],
                                "arrive_customer_response" => ['type' => 8, 'data' => ['order' => ['id' => 1]]],
                                "cancel_order_response" => ['type' => 9, 'data' => ['order' => ['id' => 5]]],
                                "check_status_response" => ['type' => 10, 'data' => ['is_in_trip' => true]]
                            ]
                        );
                        $conn->send(json_encode($example));
                        break;
                }
            }
        }
        elseif (isset($conn->dispatcher_token) && $this->verifyDispatcherConn($conn)){
            //handle redis commands
            if(isset($data->command)){
                switch ($data->command){
                    case 'delivery_request':
                        if(isset($data->order_id)){
                            $this->sendDeliveryRequest($data->order_id,1);
                        }
                        else{
                            $conn->close();
                        }
                        break;
                    case 'captain_arrived':
                        if(isset($data->order_id)){
                            $order = $this->getOrderById($data->order_id);
                            if(!empty($order->captain_arrived_at)
                                && !empty($order->captain_accepted_at)
                                && !empty($order->captain_id)
                                && empty($order->captain_picked_order_at)
                                && isset($this->subscribers_locations[$order->captain_id])){
                                $order = (new RecentTransformer)->transformForSocket($order);
                                $this->subscribers_locations[$order['captain_id']]['user']->conn->send(json_encode(['type' => 61, 'data' => ['hide' => true]]));
                                //show confirm pickup dialog
                                $this->subscribers_locations[$order['captain_id']]['user']->conn->send(json_encode(['type' => 62, 'data' => ['order' => $order]]));
//                                $conn->send(json_encode(['successfully']));
                            }

                        }
                        else{
                            $conn->close();
                        }
                        break;
                    case 'hide_request':
                        if(isset($data->order_id)){
                            $order = $this->getOrderById($data->order_id);
                            foreach ($this->subscribers_locations as $id => &$subscribers_location)
                            {
                                if(isset($subscribers_location['request_group_id'])){
                                    \Log::notice("\n request group id: ".explode("-", $subscribers_location['request_group_id'], 2)[0]."\n");
                                    if(explode("-", $subscribers_location['request_group_id'], 2)[0] == $data->order_id)
                                    {
                                        if(isset($subscribers_location['user'])){
                                            \Log::notice("\n condition true\n");
                                            $subscribers_location['status'] = CaptainStatuses::ONLINE;
                                            $subscribers_location['user']->conn->send(json_encode(['type' => 5, 'data' => ['message' => __('Order has been marked completed by the Merchant'), 'order' => (new RecentTransformer)->transformForSocket($order), 'request_group_id' => $subscribers_location['request_group_id'] ?? '']]));
                                            unset($subscribers_location['request_group_id']);
                                        }
                                    }
                                }
                                else{
                                    if($order->captain_id == $id
                                        && isset($subscribers_location['user'])){
                                        $subscribers_location['status'] = CaptainStatuses::ONLINE;
                                        $subscribers_location['user']->conn->send(json_encode(['type' => 5, 'data' => ['message' => __('Order has been marked completed by the Merchant'), 'order' => (new RecentTransformer)->transformForSocket($order), 'request_group_id' => $subscribers_location['request_group_id'] ?? '']]));
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        $conn->send(json_encode('no valid command provided'));
                        break;
                }
            }
        }
        else{
            $conn->close();
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        if(isset($conn->accessToken)){
            $accessToken = $conn->accessToken;
            $user = $this->getUserByToken($accessToken);

            if($conn->type == 'captain')
            {
                $this->updateCaptain($user->id,[
                    'status' => CaptainStatuses::OFFLINE
                ]);
                if (isset($this->users[$accessToken])) {
                    unset($this->users[$accessToken]);
                    unset($this->subscribers_locations[$user->id]);
                }
            }
            else{
                if(isset($this->users[$accessToken]))
                {
                    unset($this->users[$accessToken]);
                    if(isset($this->customers[$user->customer_id])){
                        unset($this->customers[$user->customer_id]);
                    }
                }
            }
        }
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        report($e);
        try{
            $conn->send(json_encode(['exception' => $e->getMessage()]));
            $conn->send(json_encode(['exception line' => $e->getLine()]));
            if(isset($conn->accessToken)){
                $accessToken = $conn->accessToken;
                $user = $this->getUserByToken($accessToken);

                if($conn->type == 'captain')
                {
                    $this->updateCaptain($user->id,[
                        'status' => CaptainStatuses::OFFLINE
                    ]);
                    if (isset($this->users[$accessToken])) {
                        unset($this->users[$accessToken]);
                        unset($this->subscribers_locations[$user->id]);
                    }
                }
                else{
                    if(isset($this->users[$accessToken]))
                    {
                        unset($this->users[$accessToken]);
                        if(isset($this->customers[$user->customer_id])){
                            unset($this->customers[$user->customer_id]);
                        }
                    }
                }
            }
            $this->clients->detach($conn);
            $conn->close();
        }
        catch (\Exception $exception){
            report($exception);
            $conn->close();
        }
    }

    /**
     * @param $token
     * @return mixed|null
     */
    private function getUserByToken($token)
    {
        $tokenable = PersonalAccessToken::findToken($token);
        $user = null;
        if(!is_null($tokenable)){
            $user = $tokenable->tokenable;
        }
        return $user;
    }

    /**
     * @param $user_id
     * @param array $data
     */
    private function updateCaptain($user_id,array $data = [])
    {
        if(isset($data['status'])){
            $this->subscribers_locations[$user_id]['status'] = $data['status'];
        }
        Captain::query()
            ->where('profile_id','=',$user_id)
            ->lockForUpdate()
            ->update($data);
    }

    /**
     * @param $user
     * @param string $lat
     * @param string $long
     */
    private function updateSubscriberLocation($user,$lat = '',$long = '',$status = 1,$sub = null)
    {
        try{
            if(isset($this->subscribers_locations[$user->id])
                && isset($this->subscribers_locations[$user->id]['pending_order'])){
                $this->subscribers_locations[$user->id] = [
                    'user' => $user,
                    'lat' => $lat,
                    'long' => $long,
                    'status' => $status,
                    'request_group_id' => isset($sub['request_group_id']) && !empty($sub['request_group_id']) ? $sub['request_group_id'] : '',
                    'pending_order' => $this->subscribers_locations[$user->id]['pending_order']
                ];
            }
            else {
                $this->subscribers_locations[$user->id] = [
                    'user' => $user,
                    'lat' => $lat,
                    'long' => $long,
                    'status' => $status,
                    'request_group_id' => isset($sub['request_group_id']) && !empty($sub['request_group_id']) ? $sub['request_group_id'] : '',
                ];
            }
            if(!empty($lat) && !empty($long))
            {
                \Log::notice("\nlat: ".$lat."\n");
                \Log::notice("\nlong: ".$long."\n");
                \Log::notice("\n Captain Status: ".$this->subscribers_locations[$user->id]['status']."\n");
                if($this->subscribers_locations[$user->id]['status'] == CaptainStatuses::BUSY
                    &&
                    isset($this->subscribers_locations[$user->id]['pending_order']))
                {
                    \Log::notice("\n Captain Pending Order ID: ".$this->subscribers_locations[$user->id]['pending_order']['id']."\n");
                    $this->updateOrderTracking($this->subscribers_locations[$user->id]['pending_order']['id'],$lat,$long);
                }
            }
        }
        catch (\Exception $exception){
            report($exception);
        }
    }

    /**
     * @param $conn
     * @return bool
     */
    private function verifyDispatcherConn($conn): bool
    {
        if(!isset($conn->dispatcher_token) || $conn->dispatcher_token !== env('DISPATCHER_TOKEN')){
            $conn->close();
            return false;
        }
        return true;
    }


    private function getOrderById($orderId)
    {
        try{
             return Recent::query()->find($orderId);
        }
        catch (\Exception $exception){
            report($exception);
        }
    }

    /**
     * @param $conn
     * @param $user
     */
    private function handleCurrentTrip($conn,$user)
    {
        $pendingCaptainOrder = Recent::query()
            ->where('captain_id', '=', $user->id)
            ->whereIn('status', [OrderStatuses::ON_THE_WAY_TO_CUSTOMER, OrderStatuses::CAPTAIN_ACCEPTED])
            ->first();
        if($pendingCaptainOrder){
            if(!empty($pendingCaptainOrder->captain_accepted_at)
                && $pendingCaptainOrder->captain_id == $user->id
                && $pendingCaptainOrder->cancelled_by_id != $user->id
                && $pendingCaptainOrder->status != OrderStatuses::DELIVERED
                && $pendingCaptainOrder->status != OrderStatuses::COMPLETED)
            {
                $this->updateCaptain($user->id,[
                    'status' => CaptainStatuses::BUSY
                ]);
                if(!empty($pendingCaptainOrder->captain_arrived_at)
                    && !empty($pendingCaptainOrder->captain_accepted_at)
                    && !empty($pendingCaptainOrder->captain_id)
                    && empty($pendingCaptainOrder->captain_picked_order_at)
                    && isset($this->subscribers_locations[$pendingCaptainOrder->captain_id])){
                    $order = (new RecentTransformer)->transformForSocket($pendingCaptainOrder);
//                    $this->subscribers_locations[$pendingCaptainOrder['captain_id']]['user']->conn->send(json_encode(['type' => 61, 'data' => ['hide' => true]]));
                    //show confirm pickup dialog
                    $this->subscribers_locations[$pendingCaptainOrder['captain_id']]['user']->conn->send(json_encode(['type' => 62, 'data' => ['order' => $order]]));
//                    $conn->send(json_encode(['successfully']));
                }
                elseif(!empty($pendingCaptainOrder->captain_arrived_at)
                    && !empty($pendingCaptainOrder->captain_accepted_at)
                    && !empty($pendingCaptainOrder->captain_id)
                    && !empty($pendingCaptainOrder->captain_picked_order_at)
                    && isset($this->subscribers_locations[$pendingCaptainOrder->captain_id])
                    && empty($pendingCaptainOrder->captain_started_trip_at)){
                    //show start trip dialog
                    $conn->send(json_encode(['type' => 6, 'data' => ['order' => (new RecentTransformer)->transformForSocket($pendingCaptainOrder)]]));
                }
                elseif (!empty($pendingCaptainOrder->captain_arrived_at)
                    && !empty($pendingCaptainOrder->captain_accepted_at)
                    && !empty($pendingCaptainOrder->captain_id)
                    && !empty($pendingCaptainOrder->captain_picked_order_at)
                    && isset($this->subscribers_locations[$pendingCaptainOrder->captain_id])
                    && !empty($pendingCaptainOrder->captain_started_trip_at)
                    && empty($pendingCaptainOrder->delivered_at)){
                    $this->updateOrderTracking($pendingCaptainOrder->id,$this->subscribers_locations[$user->id]['lat'],$this->subscribers_locations[$user->id]['long']);
                    $conn->send(json_encode(['type' => 7, 'data' => ['order' => (new RecentTransformer)->transformForSocket($pendingCaptainOrder)]]));
                }
                else{
                    $conn->send(json_encode(['type' => 3, 'data' => ['accepted' => true, 'order' => (new RecentTransformer)->transformForSocket($pendingCaptainOrder)]]));
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function isPendingOrder($order_id,$customer_id): bool
    {
        return Recent::query()
                ->where('id','=',$order_id)
                ->where('customer_id', '=', $customer_id)
                ->where('status','=',OrderStatuses::ON_THE_WAY_TO_CUSTOMER)
                ->count() > 0;
    }

    /**
     * @param $order_id
     * @param $lat
     * @param $long
     */
    private function updateOrderTracking($order_id,$lat,$long)
    {
        $order = $this->getOrderById($order_id);
        $this->subscribers_locations[$order->captain_id]['pending_order'] = [
            'id' => $order->id,
            'captain_id' => $order->captain_id,
            'customer_id' => $order->customer_id,
            'latitude' => $lat,
            'longitude' => $long
        ];
        //check if customer connected to socket
        if(isset($this->customers[$order->customer_id]))
        {
            \Log::notice("\n Customer id:". $order->customer_id."\n");
            \Log::notice("\n Order id:". $order->id."\n");
            \Log::notice("\n Captain id:". $order->captain_id."\n");
            //send the location update to customer
            $this->customers[$order->customer_id]->conn->send(
                json_encode(['type' => 2, 'data' => ['order' => (new RecentTransformer)->transformForCustomer($order), 'latitude' => $lat, 'longitude' => $long]]));
            \Log::notice("\n location update sent to customer [lat: ".$lat.", long: ".$long."] \n");
        }
    }

    /**
     * @param $order_id
     */
    private function sendDeliveryRequest($order_id,$retry_number = 1)
    {
        $order = $this->getOrderById($order_id);

        //request group id to be unique for each delivery request
        $requestGroupID = $order->id. '-' . time() . $order->id;

        $this->pending_requests[$requestGroupID] = [
            'order_id' => $order->id,
            'delivery_requested_at' => time(),
            'request_group_id' => $requestGroupID,
            'retry_number' => $retry_number
        ];
        $order->fill([
            'in_socket_at' => now(),
            'request_group_id' => $requestGroupID
        ])->save();
        $fiveCaptains = getNearestCoordinates($order->merchantBranch->latitude,$order->merchantBranch->longitude,
            array_filter($this->subscribers_locations,function ($item){
//                return $item['status'] == CaptainStatuses::ONLINE;
                return isset($item['user']) && $item['user']->captain->status == CaptainStatuses::ONLINE;
            })
        );
        \Log::notice("\n five captains: ".json_encode($fiveCaptains)."\n");
        $requestedCaptains = [];
        //loop through captains to send them the delivery request
        foreach ($fiveCaptains as  &$captain) {
            if($captain['user']->captain->is_verified != 1){
                $captain['user']->conn->send(json_encode(['type' => 403,'data' => ['message' => __('Your captain profile should be verified by :app_name Administrator',['app_name' => appName()])]]));
                $captain['user']->conn->close();
            }
            else if($captain['user']->captain->is_paused == 1){
                $captain['user']->conn->send(json_encode(['type' => 405,'data' => ['message' => __('Your captain profile is paused please contact :your_company',['your_company' => env('DELIVERY_COMPANY') ?? appName()])]]));
                $captain['user']->conn->close();
            }
            else
            {
                $captain['status'] = CaptainStatuses::PENDING_REQUEST;
                $captain['request_group_id'] = $requestGroupID;
                array_push($requestedCaptains,$captain);
                $captain['user']->conn->send(json_encode(['type' => 2, 'data' => ['order' => (new RecentTransformer)->transformForSocket($order), 'distance' => $captain['distance'], 'request_group_id' => $requestGroupID]]));
            }
        }
        \Log::notice("\n requested captains: ".json_encode($fiveCaptains)."\n");
        $this->pending_requests[$requestGroupID]['requested_captains'] = $requestedCaptains;
    }

    /**
     *
     */
    public function sendPendingOrderDeliveryRequestFromDB()
    {
        Recent::query()->whereNotNull('merchant_accepted_at')
            ->whereNotIn('id',collect($this->pending_requests)->pluck('order_id'))
            ->where('status','=',OrderStatuses::PENDING_CAPTAIN_ACCEPT)
            ->whereNotIn('request_group_id',array_keys($this->pending_requests))
            ->whereNull('merchant_rejected_at')
            ->whereNull('captain_accepted_at')
            ->whereNull('captain_id')
            ->whereHas('customer')
            ->inRandomOrder()
            ->chunk(5,function ($recents){
                foreach ($recents as $recent){
                    if(sizeof(array_filter($this->pending_requests,function ($req)use($recent){
                            return $req['order_id'] == $recent->id;
                        })) == 0){
                        \Log::warning('send request from DB for order: '.$recent->id);
                        $this->sendDeliveryRequest($recent->id,1);
                    }
                }
            });
    }
}

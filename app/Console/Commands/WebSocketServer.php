<?php

namespace App\Console\Commands;

use App\Domains\Delivery\Http\Controllers\WebSocketController;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Web socket server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $socketServer = new WebSocketController();
        $wsServer = new WsServer(
            $socketServer
        );
        $server = IoServer::factory(
            new HttpServer(
                $wsServer
            ),
            8090,
            '0.0.0.0'
        );
        $this->info('Web socket server 1 is running...');
        $this->warn(' Server:'. $server->socket->getAddress());

        $server->loop->addPeriodicTimer(5, function () use ($socketServer) {
            $socketServer->checkPendingRequests();
        });

        $server->loop->addPeriodicTimer(60,function () use ($socketServer){
            $socketServer->sendPendingOrderDeliveryRequestFromDB();
        });

        $wsServer->enableKeepAlive($server->loop,30);

        $server->run();
    }
}

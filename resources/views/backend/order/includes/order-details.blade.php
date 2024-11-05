@extends('backend.layouts.app')
@section('title', __('Order Details'))
<link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-UkVD+zxJKGsZP3s/JuRzapi4dQrDDuEf/kHphzg8P3v8wuQ6m9RLjTkPGeFcglQU" crossorigin="anonymous">

@section('content')


    <x-backend.card>
        <x-slot name="header">
            @lang('Order Details')
        </x-slot>
        <x-slot name="headerActions">
            <x-utils.link  class="card-header-action" :href="route('admin.order.index')" :text="__('Back')" />
        </x-slot>
        <x-slot name="body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-coreui-toggle="pill" data-coreui-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                        {{__("Order Information")}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill" data-coreui-target="#pills-merchant" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{__("Merchant Information")}}</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill" data-coreui-target="#pills-customer" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{__("Customer Information")}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill" data-coreui-target="#pills-captain" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{__("Captain Information")}}</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0"><table class="table">
                        <table class="table">
                            <tbody class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{__("Order Reference")}}</th>
                                <th scope="col">{{__("Order Amount")}}</th>
                                <th scope="col">{{__("Delivery Amount")}}</th>
                                <th scope="col">{{__("Notes")}}</th>
                                @if(isset($order->voice_record))
                                <th scope="col">{{__("Voice Record")}}</th>
                                @endif
                                <th scope="col">{{__("Date")}}</th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            <tr>
                                <th>{{$order->order_reference}}</th>
                                <td>{{$order->order_amount}}</td>
                                <td>{{$order->delivery_amount}}</td>
                                <td>{{$order->notes}}</td>
                                @if(isset($order->voice_record))
                                <td>
                                    <audio controls class="w-100">
                                        <source
                                            src="{{storageBaseLink(\App\Enums\Core\StoragePaths::ORDER_VOICE_RECORD.$order->voice_record)}}"
                                        />
                                        Audio not supported
                                    </audio>
                                </td>
                                @endif
                                <td>{{$order->created_at}}</td>

                            </tr>
                            </tbody>
                        </table></table></div>
                <div class="tab-pane fade" id="pills-merchant" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0"><table class="table">
                        <table class="table">
                            <tbody class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{__("Merchant Name")}}</th>
                            <th scope="col">{{__("Merchant Phone Number")}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <tr>
                            <td>
                                <a href="{{route('admin.merchant.show', $order->merchant_id)}}" >{{$order->merchant->name??""}}</a>
                            </td>
                            <td>
                                <a href="tel:{{$order->merchant->profile->mobile_number??""}}" >{{$order->merchant->profile->mobile_number??""}}</a>
                            </td>
                        </tr>
                        </tbody>
                        </table></table></div>
                <div class="tab-pane fade" id="pills-customer" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <table class="table">
                        <tbody class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{__("Customer Phone")}}</th>
                            <th scope="col">{{__("Delivery Destination")}}</th>
                            <th scope="col">{{__("Order Location")}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <tr>
                            <td>
                               <a href="tel:{{$order->customer_phone??""}}"> {{$order->customer_phone??""}}</a>
                            </td>
                            @if(isset($order->delivery_destination))
                            <td>{{$order->delivery_destination??"--"}}</td>
                            @endif
{{--                            <td>{{$order->getStreetName()??"--"}}</td>--}}
                            <td>    <a href="https://maps.google.com/?q= {{ $order->latitude}},{{ $order->longitude}}" target="_blank">{{__("View In Map")}}</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if(isset($order->captain))
                <div class="tab-pane fade" id="pills-captain" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <table class="table">
                        <tbody class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{__("Captain Name")}}</th>
                            <th scope="col">{{__("Captain Number")}}</th>
                            <th scope="col">{{__("Captain Requested At")}}</th>
                            <th scope="col">{{__("Captain Accepted At")}}</th>
                            <th scope="col">{{__("Captain Arrived At")}}</th>
                            <th scope="col">{{__("Captain Started Trip At")}}</th>
                            <th scope="col">{{__("Captain On The Way At")}}</th>
                            <th scope="col">{{__("Delivered At")}}</th>
                            <th scope="col">{{__("Captain Picked Order At")}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <tr>
                            <td><a @if(isset($order->captain))href="{{route('admin.captain.show', $order->captain_id)}}" @endif  >{{$order->captain->name??""}}</a></td>
                            <td><a href="tel:{{$order->captain->country_code??""}}{{$order->captain->mobile_number??""}}">{{$order->captain->country_code??""}}{{$order->captain->mobile_number??""}}</a></td>
                            <td>{{ $order->captain_requested_at}}</td>
                            <td>{{ $order->captain_accepted_at}}</td>
                            <td>{{ $order->captain_arrived_at}}</td>
                            <td>{{ $order->captain_started_trip_at}}</td>
                            <td>{{ $order->captain_on_the_way_at}}</td>
                            <td>{{ $order->delivered_at}}</td>
                            <td>{{ $order->captain_picked_order_at}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                    @endif
            </div>
        </x-slot>
    </x-backend.card>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.0/dist/js/coreui.bundle.min.js" integrity="sha384-n0qOYeB4ohUPebL1M9qb/hfYkTp4lvnZM6U6phkRofqsMzK29IdkBJPegsyfj/r4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity=" sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.0/dist/js/coreui.min.js" integrity="sha384-2hww80ziDjQXYpFulPf5tfdCCXLTxn70HdSwL9MfeEvpS0kjfHd1iaBRsLpnuaSC" crossorigin="anonymous"></script>
@endsection

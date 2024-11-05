<x-livewire-tables::bs4.table.cell>
   {{$row->order_reference}}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    @if(!empty($row->merchant_id))
    <a href="{{route('admin.merchant.show', $row->merchant_id)}}" >{{$row->merchant->name??""}}</a>
    @else
        {{   __('Not assigned yet')}}
    @endif
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    {{ $row->order_amount }}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    {{ $row->delivery_amount }}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    @if(!empty($row->customer_phone))
        <a href="tel:  {{$row->customer_phone??''}}" >  {{$row->customer_phone??''}}</a>
    @else
        {{   __('Not assigned yet')}}
    @endif
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    @if($row->status==1)
        <span class="badge badge-primary">{{__("New Order")}}</span>
    @elseif($row->status==2)
        <span class="badge badge-secondary">{{__("Pending Captain Accept")}}</span>
    @elseif($row->status==-1)
        <span class="badge badge-danger">{{__("Rejected By Merchant")}}</span>
    @elseif($row->status==-2)
        <span class="badge badge-danger"> {{__("Captain Cancelled")}}</span>
    @elseif($row->status==3)
        <span class="badge badge-danger">{{__("Captain Cancelled")}}</span>
    @elseif($row->status==4)
        <span class="badge badge-info"> {{__("On The Way To Customer")}}</span>
    @elseif($row->status==5)
        <span class="badge badge-success">{{__("Delivered")}}</span>
    @elseif($row->status==6)
        <span class="badge badge-success"> {{__("Completed")}}</span>
    @endif
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    @if(isset($row->latitude)&&$row->latitude!=0&&isset($row->longitude)&&$row->longitude!=0)
{{--    {{$street}}--}}
    @endif
    <a href="https://maps.google.com/?q= {{ $row->latitude}},{{ $row->longitude}}" target="_blank">{{__("View In Map")}}</a>
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    <a href="{{route('admin.order.orderDetails', $row->id)}}"> <button class="btn btn-primary">
            <i class="bi bi-search"></i> {{("Show Details")}}
        </button> </a>
</x-livewire-tables::bs4.table.cell>

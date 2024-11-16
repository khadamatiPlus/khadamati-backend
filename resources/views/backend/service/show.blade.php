@extends('backend.layouts.app')
@section('title', __('View Service'))
@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('View Service')
        </x-slot>
        <x-slot name="headerActions">
            <x-utils.link class="card-header-action" :href="route('admin.service.index')" :text="__('Back')" />
        </x-slot>
        <x-slot name="body">
            <table class="table table-hover">
                <tr>
                    <th>@lang('Title')</th>
                    <td>{{$service->title}}</td>
                </tr>
                <tr>
                    <th>@lang('Merchant')</th>
                    <td>{{$service->merchant->name}}</td>
                </tr>
                <tr>
                    <th>@lang('Category')</th>
                    <td>{{$service->category->name}}</td>
                </tr>
                <tr>
                    <th>@lang('Sub Category')</th>
                    <td>{{$service->category->name}}</td>
                </tr>
                <tr>
                    <th>@lang('Main Image')</th>
                    <td>
                        @php
                            $serviceMainImage=\App\Domains\Service\Models\ServiceImage::query()->where('service_id',$service->id)->where('is_main',1)->first();
                        @endphp
                        @if(isset($serviceMainImage->image))
                            <img src="{{storageBaseLink($serviceMainImage->image)}}" width="100"  loading="lazy" />
                        @else
                            ----------------
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('Description')</th>
                    <td>{!! $service->description !!}</td>
                </tr>
                <tr>
                    <th>@lang('Price')</th>
                    <td>{{$service->price}}</td>
                </tr>
                <tr>
                    <th>@lang('New Price')</th>
                    <td>{{$service->new_price}}</td>
                </tr>
                <tr>
                    <th>@lang('Duration')</th>
                    <td>{{$service->duration}}</td>
                </tr>
                <tr>
                    <th>@lang('Order')</th>
                    <td>{{$service->order}}</td>
                </tr>
                <tr>
                    <th>@lang('Tags')</th>
                    <td>
                        @foreach($service->tags as $tag)

                            <span class="badge badge-primary"> {{$tag->name}}</span>

                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>@lang('Products')</th>
                    <td>
                        @foreach($service->products as $index=> $product)

                            <h4>{{__("Product")}} {{$index+1}}</h4>
                             <b>{{__("Title:")}}</b> {{$product->title}}
                             <b>{{__("Price:")}}</b> {{$product->price}}
                             <b>{{__("Duration:")}}</b> {{$product->duration}}
                             <b>{{__("Description:")}}</b> {{$product->description}}
                             <b>{{__("order:")}}</b> {{$product->order}}
                             <b>{{__("Image:")}}</b>
                            @if(!empty($product->image))
                                <img src="{{storageBaseLink($product->image)}}" width="50" height="50" loading="lazy" onerror="this.src='{{ asset('img/brand/default.png') }}'" />
                            @else
                                @lang('No Service Image')
                            @endif

                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>@lang('Created By')</th>
                    <td>{{$service->createdById->name??"Not Found"}}</td>
                </tr>
            </table>
        </x-slot>
        <x-slot name="footer">
            <small class="float-right text-muted">
                <strong>@lang('Service Created'):</strong> {{ $service->created_at->format('Y-m-d H:i:s') }} ({{ $service->created_at->diffForHumans() }}),
                <strong>@lang('Last Updated'):</strong> {{ $service->updated_at->format('Y-m-d H:i:s') }} ({{ $service->updated_at->diffForHumans() }})
                @if($service->trashed())
                    <strong>@lang('Account Deleted'):</strong> {{ $service->deleted_at->format('Y-m-d H:i:s') }} ({{ $service->deleted_at->diffForHumans() }})
                @endif
            </small>

        </x-slot>
    </x-backend.card>
@endsection


<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="{{ __('Search') }}" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Phone Number') }}</th>
            <th>{{ __('Country') }}</th>
            <th>{{ __('City') }}</th>
            <th>{{ __('Image') }}</th>
            <th>{{ __('Approve') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchants as $merchant)
            <tr>
                <td>{{ $merchant->name }}</td>
                <td>
                    @if(!empty($merchant->profile->mobile_number))
                        <a href = "tel: {{ $merchant->profile->mobile_number }}">{{ $merchant->profile->mobile_number }}</a>
                    @else
                        @lang('Empty')
                    @endif
                </td>
                <td>  {{ $merchant->country->name??'------------' }}</td>
                <td>
                    {{ $merchant->city->name }}
                </td>
                <td>
                    @if(isset($merchant->profile_pic))
                        <img class="zoom" src="{{storageBaseLink(\App\Enums\Core\StoragePaths::MERCHANT_PROFILE_PIC.$merchant->profile_pic??'')}}" width="100"  loading="lazy" />
                    @else
                        ----------------
                    @endif
                </td>

                <td>
                    <input type="checkbox" name="is_verified" id="is_verified" data-toggle="toggle" data-size="sm" data-onstyle="primary" onchange="changeCheckBox({{$merchant->id}})" value="{{ old($merchant->is_verified) ?? ($merchant->is_verified == 0)?'no':'yes'}}" {{$merchant->is_verified == 1 ? 'checked' : ''}} >
                </td>

                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.merchant.show'))
                        <x-utils.view-button :href="route('admin.merchant.show', $merchant)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.merchant.update'))
                        <x-utils.edit-button :href="route('admin.merchant.edit', $merchant)" />
                    @endif


                            <script>
                                function changeCheckBox(id){
                                    debugger
                                    $.ajax({
                                        url : '{{route('admin.merchant.updateStatusByMerchantId')}}?'+'merchantId='+id,
                                        type:'GET',
                                        async : false,
                                        success:function(data){
                                            if(data){
                                            }
                                        },
                                        error:function (xhr){
                                            alert(xhr.message);
                                        }
                                    })
                                }
                            </script>

                </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div>
    {{ $merchants->links() }}
</div>
</div>


<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="{{ __('Search') }}" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('Main Image') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Merchant') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr>
                <td>
                    @if(isset($service->image))
                        <img src="{{storageBaseLink(\App\Enums\Core\StoragePaths::SERVICE_FILE.$service->image)}}" width="100"  loading="lazy" />
                    @else
                        ----------------
                    @endif
                </td>
                <td>{{ $service->title }}</td>
                <td>  {{ $service->merchant->name}}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.service.update'))
                        <x-utils.edit-button :href="route('admin.service.edit', $service)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.service.delete'))
                        <x-utils.delete-button :href="route('admin.service.delete', $service)" />
                    @endif
                </td>

        </tr>


    @endforeach
    </tbody>
</table>

<div>
    {{ $services->links() }}
</div>
</div>

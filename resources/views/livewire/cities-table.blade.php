
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
            <th>{{ __('Country') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
            <tr>
                <td>{{ $city->name }}</td>
                <td>{{ $city->country->name }}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.city.update'))
                        <x-utils.edit-button :href="route('admin.lookups.city.edit', $city)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.city.delete'))
                        <x-utils.delete-button :href="route('admin.lookups.city.delete', $city)" />
                    @endif

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $cities->links() }}
</div>
</div>


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
            <th>{{ __('Permissions') }}</th>
            <th>{{ __('Number of Admins') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td> {!!$role->permissions_label !!}</td>
                <td> {!!$role->users_count !!}</td>
                <td>
                    @if (!$role->isAdmin())
                        <x-utils.edit-button :href="route('admin.auth.role.edit', $role)" />
                        <x-utils.delete-button :href="route('admin.auth.role.destroy', $role)" />
                    @endif

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $roles->links() }}
</div>
</div>

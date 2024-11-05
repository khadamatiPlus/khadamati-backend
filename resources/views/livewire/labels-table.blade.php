
<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="{{ __('Search') }}" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('Key') }}</th>
            <th>{{ __('Value') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($labels as $label)
            <tr>
                <td>{{ $label->key }}</td>
                <td>{{ $label->value }}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.label.update'))
                        <x-utils.edit-button :href="route('admin.lookups.label.edit', $label)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.label.delete'))
                        <x-utils.delete-button :href="route('admin.lookups.label.delete', $label)" />
                    @endif

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $labels->links() }}
</div>
</div>

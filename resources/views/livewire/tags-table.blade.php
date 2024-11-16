
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
            <th>{{ __('Parent') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->parent->name??"" }}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.tag.update'))
                        <x-utils.edit-button :href="route('admin.lookups.tag.edit', $tag)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.tag.delete'))
                        <x-utils.delete-button :href="route('admin.lookups.tag.delete', $tag)" />
                    @endif

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $tags->links() }}
</div>
</div>


<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="{{ __('Search') }}" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{!! $page->description !!}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.page.update'))
                        <x-utils.edit-button :href="route('admin.lookups.page.edit', $page)" />
                    @endif
{{--                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.page.delete'))--}}
{{--                        <x-utils.delete-button :href="route('admin.lookups.page.delete', $page)" />--}}
{{--                    @endif--}}

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $pages->links() }}
</div>
</div>

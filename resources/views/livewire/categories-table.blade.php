
<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="{{ __('Search') }}" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('Image') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('summary') }}</th>
            <th>{{ __('Parent') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    @if(isset($category->image))
                        <img class="zoom" src="{{storageBaseLink(\App\Enums\Core\StoragePaths::CATEGORY_IMAGE.$category->image??'')}}" width="100"  loading="lazy" />
                    @else
                        ----------------
                    @endif
                </td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->summary }}</td>
                <td>  {{ $category->category->name??'------------' }}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.category.update'))
                        <x-utils.edit-button :href="route('admin.lookups.category.edit', $category)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.category.delete'))
                        <x-utils.delete-button :href="route('admin.lookups.category.delete', $category)" />
                    @endif

                </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div>
    {{ $categories->links() }}
</div>
</div>

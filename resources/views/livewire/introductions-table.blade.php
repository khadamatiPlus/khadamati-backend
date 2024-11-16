
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
            <th>{{ __('Title') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($introductions as $introduction)
            <tr>
                <td>
                    @if(isset($introduction->image))
                        <img src="{{storageBaseLink(\App\Enums\Core\StoragePaths::INTRODUCTION_IMAGE.$introduction->image)}}" width="100"  loading="lazy" />
                    @else
                        ----------------
                    @endif
                </td>
                <td>{{ $introduction->title }}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.introduction.update'))
                        <x-utils.edit-button :href="route('admin.introduction.edit', $introduction)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.introduction.delete'))
                        <x-utils.delete-button :href="route('admin.introduction.delete', $introduction)" />
                    @endif
                </td>

        </tr>


    @endforeach
    </tbody>
</table>

<div>
    {{ $introductions->links() }}
</div>
</div>

{{--@if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.setting.update'))--}}
{{--    <x-utils.edit-button :href="route('admin.setting.edit', $model)" />--}}
{{--@endif--}}
{{--@if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.setting.delete'))--}}
{{--    <x-utils.delete-button :href="route('admin.setting.delete', $model)" />--}}
{{--@endif--}}
{{--{{$model->name}}--}}

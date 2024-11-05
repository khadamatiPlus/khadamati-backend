@if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.vehicleType.update'))
    <x-utils.edit-button :href="route('admin.lookups.vehicleType.edit', $model)" />
@endif
@if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.lookups.vehicleType.delete'))
    <x-utils.delete-button :href="route('admin.lookups.vehicleType.delete', $model)" />
@endif

{{--<a class="btn btn-info btn-sm" href="{{route('admin.captain.getCaptain')}}?filters[vehicle_type_id]={{$model->id}}">@lang('Get Captain')</a>--}}

{{--<a class="btn btn-info btn-sm" href="{{route('admin.report.captains_report.getCaptainReport')}}?filters[vehicle_type_id]={{$model->id}}">@lang('Get Captain Report')</a>--}}

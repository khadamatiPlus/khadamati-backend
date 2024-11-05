@if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.emailEngine.mailTemplate.update'))
    <x-utils.edit-button :href="route('admin.emailEngine.mailTemplate.edit', $model)" />
@endif

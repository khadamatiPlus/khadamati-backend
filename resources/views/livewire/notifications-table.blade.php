
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
            <th>{{ __('Description') }}</th>
            <th>{{ __('Type') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($notifications as $notification)
            <tr>
                <td>
                    @if(isset($notification->notification_icon))
                        <img src="{{storageBaseLink(\App\Enums\Core\StoragePaths::NOTIFICATION_ICON.$notification->notification_icon)}}" width="100"  loading="lazy" />
                    @else
                        ----------------
                    @endif
                </td>
                <td>{{ $notification->title }}</td>
                <td> {!!$notification->description !!}</td>
                <td>  {{ $notification->type}}</td>
                <td>
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.notification.update'))
                        <x-utils.edit-button :href="route('admin.notification.edit', $notification)" />
                    @endif
                    @if ($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.notification.delete'))
                        <x-utils.delete-button :href="route('admin.notification.delete', $notification)" />
                    @endif


                        <button onclick="send({{$notification->id}})" class="btn btn-success btn-sm"><i class="fas fa-paper-plane"></i> {{__("Send")}}</button>
                        @push('after-scripts')
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                function send(id) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '{{route('admin.notification.sendNotification')}}?'+'notificationId='+id,
                                        success: function (data) {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: '{{__('The Notification was successfully Sent.')}}',
                                            })
                                        }
                                    });
                                }
                            </script>
                        @endpush
                </td>

        </tr>


    @endforeach
    </tbody>
</table>

<div>
    {{ $notifications->links() }}
</div>
</div>

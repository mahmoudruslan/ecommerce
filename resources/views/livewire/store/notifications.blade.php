<div>
    <li class="nav-item dropdown {{ $unreadNotificationsCount == 0 ? 'd-none' : '' }}">
        <a
        {{-- wire:click="$emit('re')"  --}}
        class="nav-link" id="alertsDropdown" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i style="position: relative;" class="fas fa-bell fa-fw"><span
                    class="notify-count">{{ $unreadNotificationsCount }}</span></i>
        </a>
        <div class="dropdown-menu dropdown-menu-sm-start mt-3 shadow-sm" aria-labelledby="alertsDropdown">
            @foreach ($unreadNotifications as $notify)
                <div style="padding: 0.25rem 0.5rem;white-space: unset" role="button"
                    class="dropdown-item d-flex align-items-center" wire:click="markAsRead('{{ $notify->id }}')">
                    <div>
                        {{-- <div class="small text-gray-500">{{$notify->created_at}}</div> --}}
                        <div style="padding: 10px">
                            {{ __('Your order #:ref_id status has been updated to :status.', [
                                'ref_id' => $notify->data['ref_id'],
                                'status' => __($notify->data['order_status']),
                            ]) }}
                        </div>
                    </div>
                </div>
            {{-- @empty
                <div style="padding: 0.25rem 0.5rem;white-space: unset" role="button"
                    class="dropdown-item d-flex align-items-center">
                    <div>
                        <div class="small text-gray-500"></div>
                        <div style="padding: 10px">
                            {{ __('No notifications!') }}
                        </div>
                    </div>
                </div> --}}
            @endforeach
        </div>
    </li>
</div>

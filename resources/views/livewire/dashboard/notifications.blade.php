<div>
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">{{ $unreadNotificationsCount}}</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                {{ __('Alerts Center') }}
            </h6>
            @forelse ($unreadNotifications as $notify)
                <div role="button" class="dropdown-item d-flex align-items-center" wire:click="markAsRead('{{$notify->id}}')">
                    <div class="me-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{$notify->created_at}}</div>
                        <span class="font-weight-bold">A new order with amount ({{$notify->data['amount']}}) from {{$notify->data['customer_name']}}</span>
                    </div>
                </div>
            @empty
            <div class="dropdown-item text-center">
                <span class="font-weight-bold">{{__('No notifications!')}}</span>
            </div>
            @endforelse
            {{-- <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-donate text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                </div>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                </div>
            </a> --}}
            <a class="dropdown-item text-center small text-gray-500" href="#">{{ __('Show All Alerts') }}</a>
        </div>
    </li>
</div>

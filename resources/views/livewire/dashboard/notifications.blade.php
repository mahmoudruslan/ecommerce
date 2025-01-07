<div>
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1 {{ $unreadNotificationsCount == 0 ? 'd-none' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">{{ $unreadNotificationsCount }}</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                {{ __('Alerts Center') }}
            </h6>
            @foreach ($unreadNotifications as $notify)
                <div role="button" class="dropdown-item d-flex align-items-center"
                    wire:click="markAsRead('{{ $notify->id }}')">
                    <div class="m-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $notify->created_at }}</div>
                        <span class="font-weight-bold">A new order with amount ({{ $notify->data['amount'] }}) from
                            {{ $notify->data['customer_name'] }}</span>
                    </div>
                </div>
            @endforeach
            <a class="dropdown-item text-center small text-gray-500" href="#">{{ __('Show All Alerts') }}</a>
        </div>
    </li>
</div>

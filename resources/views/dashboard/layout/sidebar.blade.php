        {{-- get route name to active dropdown list --}}
        @php $path = explode('/', Request::path());
            $route = $path[1] ?? '';
        @endphp
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> {{ config('app.name') }}</div>
            </a>
            <!-- Divider -->
            @can('main')
                <hr class="sidebar-divider my-0">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>{{__('Main')}}</span></a>
                </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                {{__('Pages')}}
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider">
            {{-- categories --}}
            @canany(['categories','store-categories', 'update-categories', 'show-categories','delete-categories'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-boxes"></i>
                    <span>{{__('Categories')}}</span>
                </a>
                <div id="collapseCategory" class="collapse @if($route == 'categories') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Categories Screens:')}} </h6>
                        @can(['store-categories'])<a class="collapse-item" href="{{route('admin.categories.create')}}">{{__('Add Categories')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.categories.index')}}">{{__('Categories')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- tags --}}
            @canany(['tags','store-tags', 'update-tags', 'show-tags','delete-tags'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTag"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-pen"></i>
                    <span>{{__('Tags')}}</span>
                </a>
                <div id="collapseTag" class="collapse @if($route == 'tags') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Tags Screens:')}} </h6>
                        @can(['store-tags'])<a class="collapse-item" href="{{route('admin.tags.create')}}">{{__('Add Tags')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.tags.index')}}">{{__('Tags')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- Products --}}
            @canany(['products','store-products', 'update-products', 'show-products','delete-products'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-store"></i>
                    <span>{{__('Products')}}</span>
                </a>
                <div id="collapseProducts" class="collapse @if($route == 'products') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Categories Screens:')}} </h6>
                        @can(['store-products'])<a class="collapse-item" href="{{route('admin.products.create')}}">{{__('Add Products')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.products.index')}}">{{__('Products')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- settings --}}
            @canany(['roles','store-roles', 'update-roles', 'show-roles','delete-roles'])
                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-low-vision"></i>
                    <span>{{__('Roles and permissions')}}</span>
                </a>
                <div id="collapseSettings" class="collapse @if($route == 'permission-role') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Roles and permissions Screens:')}} </h6>
                        @can('store-roles')<a class="collapse-item" href="{{route('admin.permission-roles.create')}}">{{__('Add roles and permissions')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.permission-roles.index')}}">{{__('Roles and permissions')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- users --}}
            @canany(['users','store-users', 'update-users', 'show-users','delete-users'])
                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users"></i>
                    <span>{{__('Users')}}</span>
                </a>
                <div id="collapseUsers" class="collapse @if($route == 'users') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Users Screens:')}} </h6>
                        @can('store-users')<a class="collapse-item" href="{{route('admin.users.create')}}">{{__('Add Users')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.users.index')}}">{{__('Users')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- supervisors --}}
            @canany(['supervisors','store-supervisors', 'update-supervisors', 'show-supervisors','delete-supervisors'])
                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupervisors"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-user-cog"></i>
                    <span>{{__('Supervisors')}}</span>
                </a>
                <div id="collapseSupervisors" class="collapse @if($route == 'supervisors') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Supervisors Screens:')}} </h6>
                        @can('store-supervisors')<a class="collapse-item" href="{{route('admin.supervisors.create')}}">{{__('Add Supervisors')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.supervisors.index')}}">{{__('Supervisors')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- coupons --}}
            @canany(['coupons','store-coupons', 'update-coupons', 'show-coupons','delete-coupons'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupons"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-money-check-alt"></i>
                    <span>{{__('Coupons')}}</span>
                </a>
                <div id="collapseCoupons" class="collapse @if($route == 'coupons') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Coupons Screens:')}} </h6>
                        @can('store-coupons')<a class="collapse-item" href="{{route('admin.coupons.create')}}">{{__('Add coupons')}}</a>@endcan
                        <a class="collapse-item" href="{{route('admin.coupons.index')}}">{{__('Coupons')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- governorates --}}
            @canany(['governorates','store-governorates', 'update-governorates', 'show-governorates','delete-governorates'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGovernorates"
                    aria-expanded="true" aria-controls="collapsePages">
                    {{-- <i class="fa fa-map-marker"></i> --}}
                    <i class="fa fa-map-marker-alt"></i>
                    <span>{{__('Governorates')}}</span>
                </a>
                <div id="collapseGovernorates" class="collapse @if($route == 'governorates') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Governorates Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.governorates.index')}}">{{__('Governorates')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- cities --}}
            @canany(['cities','store-cities', 'update-cities', 'show-cities','delete-cities'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCities"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-map-pin"></i>
                    <span>{{__('Cities')}}</span>
                </a>
                <div id="collapseCities" class="collapse @if($route == 'cities') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Cities Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.cities.index')}}">{{__('Cities')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- reviews --}}
            @canany(['reviews','store-reviews', 'update-reviews', 'show-reviews','delete-reviews'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReviews"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-comment"></i>
                    <span>{{__('Reviews')}}</span>
                </a>
                <div id="collapseReviews" class="collapse @if($route == 'reviews') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Reviews Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.reviews.index')}}">{{__('Reviews')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            {{-- user addresses --}}
            @canany(['user-addresses','show-user-addresses','delete-user-addresses','update-user-addresses','store-user-addresses'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUserAddresses"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-comment"></i>
                    <span>{{__('Users addresses')}}</span>
                </a>
                <div id="collapseUserAddresses" class="collapse @if($route == 'user-addresses') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Users addresses screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.user-addresses.index')}}">{{__('Users addresses')}}</a>
                    </div>
                </div>
            </li>
            @endcanany
            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Settings') }}
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            {{-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="{{asset('dashboard/img/undraw_rocket.svg')}}" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> --}}

        </ul>


        {{--
                        <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>


            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.charts')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.tables')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="{{route('admin.buttons')}}">Buttons</a>
                        <a class="collapse-item" href="{{route('admin.cards')}}">Cards</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>
            --}}

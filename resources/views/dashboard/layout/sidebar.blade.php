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
            @can(['can:categories'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{__('Categories')}}</span>
                </a>
                <div id="collapseCategory" class="collapse @if($route == 'categories') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Categories Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.categories.create')}}">{{__('Add Categories')}}</a>
                        <a class="collapse-item" href="{{route('admin.categories.index')}}">{{__('Categories')}}</a>
                    </div>
                </div>
            </li>
            @endcan
            {{-- Products --}}
            @can(['can:products'])
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{__('Products')}}</span>
                </a>
                <div id="collapseProducts" class="collapse @if($route == 'products') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Categories Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.products.create')}}">{{__('Add Products')}}</a>
                        <a class="collapse-item" href="{{route('admin.products.index')}}">{{__('Products')}}</a>
                    </div>
                </div>
            </li>
            @endcan
            {{-- settings --}}
            @can(['can:roles'])
                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{__('Roles and permissions')}}</span>
                </a>
                <div id="collapseSettings" class="collapse @if($route == 'permission-role') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Roles and permissions Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.permission-role.create')}}">{{__('Add roles and permissions')}}</a>
                        <a class="collapse-item" href="{{route('admin.permission-role.index')}}">{{__('Roles and permissions')}}</a>
                    </div>
                </div>
            </li>
            @endcan
                        {{-- users --}}
            @can(['users'])
                <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{__('Users')}}</span>
                </a>


                <div id="collapseUsers" class="collapse @if($route == 'users') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{__('Users Screens:')}} </h6>
                        <a class="collapse-item" href="{{route('admin.users.create')}}">{{__('Add users')}}</a>
                        <a class="collapse-item" href="{{route('admin.users.index')}}">{{__('Users')}}</a>
                    </div>
                </div>
            </li>
            @endcan
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

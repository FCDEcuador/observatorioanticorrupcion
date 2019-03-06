        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{!! route('backend.dashboard') !!}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            @if($oConfiguration->backend_logo != '')
                                <img src="{!! asset($oStorage->url($oConfiguration->backend_logo)) !!}" alt="BlaudCMS" class="dark-logo" height="70" />
                                <!-- Light Logo icon -->
                                <img src="{!! asset($oStorage->url($oConfiguration->backend_logo)) !!}" alt="BlaudCMS" class="light-logo" height="70" />
                            @else
                                <img src="{!! asset('public/backend/assets/images/logoBlaud.png') !!}" alt="BlaudCMS" class="dark-logo" height="70" />
                                <!-- Light Logo icon -->
                                <img src="{!! asset('public/backend/assets/images/logoBlaud.png') !!}" alt="BlaudCMS" class="light-logo" height="70" />
                            @endif
                        </b>
                        <!--End Logo icon -->
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item hidden-sm-down"></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        
                        
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user()->avatar != '')
                                    <img src="{!! asset($oStorage->url(Auth::user()->avatar)) !!}" alt="user" class="profile-pic" />
                                @else
                                    <img src="{!! asset('public/backend/assets/images/default-user.png') !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" class="profile-pic" />
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img">
                                                @if(Auth::user()->avatar != '')
                                                    <img src="{!! asset($oStorage->url(Auth::user()->avatar)) !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" />
                                                @else
                                                    <img src="{!! asset('public/backend/assets/images/default-user.png') !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" class="profile-pic" />
                                                @endif
                                            </div>
                                            <div class="u-text">
                                                <h4>{!! substr(Auth::user()->name,0,1) !!}. {!! Auth::user()->lastname !!}</h4>
                                                <p class="text-muted">{!! Auth::user()->email !!}</p>
                                                <a href="{!! route('backend.profile') !!}" class="btn btn-rounded btn-danger btn-sm">
                                                    Ver perfil
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{!! route('backend.profile') !!}">
                                            <i class="ti-user"></i> Mi Perfil
                                        </a>
                                    </li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{!! route('backend.logout') !!}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
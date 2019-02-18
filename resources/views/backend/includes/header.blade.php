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
                            <img src="{!! asset('public/backend/assets/images/logoBlaud.png') !!}" alt="BlaudCMS" class="dark-logo" width="70%" />
                            <!-- Light Logo icon -->
                            <img src="{!! asset('public/backend/assets/images/logoBlaud.png') !!}" alt="BlaudCMS" class="light-logo" width="70%" />
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
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                @if($cantUnreadMessages > 0)
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                @endif
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">{!! $cantUnreadMessages !!} mensaje(s) pendientes</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            @if($unreadMessages->isNotEmpty())
                                                @foreach($unreadMessages as $unreadMessage)
                                                    @if($unreadMessage->type == 'consulta')
                                                        @php
                                                          $text = 'Nueva consulta';
                                                          $icon = 'fa-question';
                                                          $btn = 'btn-danger';
                                                        @endphp
                                                      @endif

                                                      @if($unreadMessage->type == 'pedido')
                                                          @php
                                                              $text = 'Nuevo pedido de información';
                                                              $icon = 'fa-rocket';
                                                              $btn = 'btn-info';
                                                          @endphp
                                                      @endif

                                                      @if($unreadMessage->type == 'sugerencia')
                                                          @php
                                                              $text = 'Nueva sugerencia';
                                                              $icon = 'fa-certificate';
                                                              $btn = 'btn-success';
                                                          @endphp
                                                      @endif

                                                      @if($unreadMessage->type == 'comentario')
                                                          @php
                                                              $text = 'Nuevo comentario';
                                                              $icon = 'fa-comments';
                                                              $btn = 'btn-warning';
                                                          @endphp
                                                      @endif
                                                      @php
                                                        $now = Carbon\Carbon::now();
                                                        $messageDate = Carbon\Carbon::parse($unreadMessage->created_at);
                                                        $time = $messageDate->diffInSeconds($now);
                                                        if($time < 60){
                                                            $unitTime = 'segundos';
                                                        }else{
                                                            $time = $messageDate->diffInMinutes($now);
                                                            if($time < 60){
                                                                $unitTime = 'minutos';
                                                            }else{
                                                                $time = $messageDate->diffInHours($now);
                                                                if($time < 24){
                                                                    $unitTime = 'horas';    
                                                                }else{
                                                                    $time = $messageDate->diffInDays($now);
                                                                    $unitTime = 'días';
                                                                }
                                                            }
                                                        }
                                                      @endphp
                                                    <!-- Message -->
                                                    <a href="#">
                                                        <div class="btn {!! $btn !!} btn-circle"><i class="fa {!! $icon !!}"></i></div>
                                                        <div class="mail-contnet">
                                                            <h5>{!! $text !!}</h5> <span class="mail-desc">{!! $unreadMessage->subject !!}</span> <span class="time">Hace {!! $time !!} {!! $unitTime !!}</span> </div>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </li>
                                    @if($cantUnreadMessages > 0)
                                        <li>
                                            <a class="nav-link text-center" href="javascript:void(0);"> <strong>Ver todos los mensajes</strong> <i class="fa fa-angle-right"></i> </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        
                        
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user()->avatar != '')
                                    @if($env == 'production')
                                        <img src="{!! asset($oStorage->url(Auth::user()->avatar)) !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" class="profile-pic" />
                                    @else
                                        <img src="{!! asset('public'.$oStorage->url(Auth::user()->avatar)) !!}" alt="user" class="profile-pic" />
                                    @endif
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
                                                    @if($env == 'production')
                                                        <img src="{!! asset($oStorage->url(Auth::user()->avatar)) !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" />
                                                    @else
                                                        <img src="{!! asset('public'.$oStorage->url(Auth::user()->avatar)) !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" />
                                                    @endif
                                                @else
                                                    <img src="{!! asset('public/backend/assets/images/default-user.png') !!}" alt="{!! Auth::user()->name !!} {!! Auth::user()->lastname !!}" class="profile-pic" />
                                                @endif
                                            </div>
                                            <div class="u-text">
                                                <h4>{!! substr(Auth::user()->name,0,1) !!}. {!! Auth::user()->lastname !!}</h4>
                                                <p class="text-muted">{!! Auth::user()->email !!}</p>
                                                <a onclick="javascript: renderSection('{!! route('backend.profile') !!}');" class="btn btn-rounded btn-danger btn-sm">
                                                    Ver perfil
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a onclick="javascript: renderSection('{!! route('backend.profile') !!}');" style="cursor: pointer;">
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
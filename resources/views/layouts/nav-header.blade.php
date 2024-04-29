<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a>
                </li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
                <li class="nav-item dropdown dropdown-language">
                    @if($selected_lang=='ar')
                        <a class="nav-link dropdown-toggle" id="dropdown-flag"
                           href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="flag-icon flag-icon-sa"></i>
                            <span class="selected-language">لغة عربية</span>
                        </a>
                    @else
                        <a class="nav-link dropdown-toggle" id="dropdown-flag"
                           href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="flag-icon flag-icon-us"></i>
                            <span class="selected-language">English</span>
                        </a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}" data-language="en"><i
                                class="flag-icon flag-icon-us"></i> English</a>
                        <a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}" data-language="eg"><i
                                class="flag-icon flag-icon-sa"></i> لغة عربية</a>
                    </div>
                </li>
                {{--                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#"--}}
                {{--                                                          data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
                {{--                                                          title="Email"><i class="ficon" data-feather="mail"></i></a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-bs-toggle="tooltip"--}}
                {{--                                                          data-bs-placement="bottom" title="Chat"><i class="ficon"--}}
                {{--                                                                                                     data-feather="message-square"></i></a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#"--}}
                {{--                                                          data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
                {{--                                                          title="Calendar"><i class="ficon" data-feather="calendar"></i></a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-bs-toggle="tooltip"--}}
                {{--                                                          data-bs-placement="bottom" title=""><i class="ficon"--}}
                {{--                                                                                                     data-feather="check-square"></i></a>--}}
                {{--                </li>--}}
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-link-style">
                    <i class="ficon" data-feather="moon"></i>
                </a>
            </li>

            @include('layouts.notifications')

            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link"
                   id="dropdown-user" data-bs-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{\Auth::guard('admins')->user()->name}}</span>
                        <span class="user-status text-muted">{{ trans('dashboard.online') }}</span></div>
                    <span class="avatar"><img class="round" src="{{getProfilePicture()}}"
                                              alt="avatar" height="40" width="40"><span
                            class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="profile"><i class="me-50" data-feather="user"></i>
                        {{ trans('dashboard.user_profile') }}
                    </a>
                    <a class="dropdown-item" href="logout">
                        <i class="me-50" data-feather="power"></i>
                        {{ trans('dashboard.sign_out') }}
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

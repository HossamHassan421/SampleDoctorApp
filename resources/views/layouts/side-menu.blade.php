<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{route('home')}}">
                    <span class="brand-logo">
                            <img src="logo_light_icon.png" style="">
                    </span>
                    <h2 class="brand-text">{{ __('dashboard.project_title') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('/') }}">
                    <i data-feather="home"></i>
                    <span class="menu-item text-truncate">{{trans('side_menu.home')}}</span>
                </a>
            </li>

            @canany(['doctor-access', 'doctorSchedule-access', 'doctorEmergencySchedule-access'])
                <li class="nav-item @if(in_array(Route::currentRouteName(), ['doctor-listing', 'doctorSchedule-listing', 'doctorEmergencySchedule-listing'])) open @endif">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='briefcase'></i>
                        <span class="menu-title text-truncate">{{trans('side_menu.doctors_management')}}</span></a>
                    <ul class="menu-content">
                        @can('doctor-access')
                            <li class="{{ Route::currentRouteName() == 'doctor-listing' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('doctor-listing') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.doctors')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('doctorSchedule-access')
                            <li class="{{ Route::currentRouteName() == 'doctorSchedule-listing' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('doctorSchedule-listing') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.doctorSchedules')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('doctorEmergencySchedule-access')
                            <li class="{{ Route::currentRouteName() == 'doctorEmergencySchedule-listing' ? 'active' : '' }}"
                                @if($selected_lang == 'ar') data-toggle="tooltip"
                                title="{{trans('side_menu.doctorEmergencySchedule')}}" @endif>
                                <a class="d-flex align-items-center" href="{{ route('doctorEmergencySchedule-listing') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.doctorEmergencySchedule')}}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='download-cloud'></i>
                    <span class="menu-title text-truncate">{{trans('side_menu.analytics_reporting')}}</span></a>
                <ul class="menu-content">
                </ul>
            </li>

            @canany(['attribute-access','translation-access','generalSetting-access'])
                <li class="nav-item @if(in_array(Route::currentRouteName(), ['attribute-listing','generalSetting-edit', 'translations'])) open @endif">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='settings'></i>
                        <span class="menu-title text-truncate">{{trans('side_menu.general_settings')}}</span></a>
                    <ul class="menu-content">
                        @can('generalSetting-access')
                            <li class="{{ Route::currentRouteName() == 'generalSetting-edit' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('generalSetting-edit') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.generalSetting')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('attribute-access')
                            <li class="{{ Route::currentRouteName() == 'attribute-listing' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('attribute-listing') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.attributes')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('translation-access')
                            <li class="{{ Route::currentRouteName() == 'translations' ? 'active' : '' }}">
                                <a target="_blank" class="d-flex align-items-center" href="translations">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{trans('side_menu.translations')}}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>
    </div>
</div>

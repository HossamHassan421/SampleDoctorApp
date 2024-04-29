@php
    $totalCount = $visitsPending + $visitsGroomingPending + $travelPending + $travelRequestPending + $joiningRequestPending;
@endphp
<li class="nav-item dropdown dropdown-notification me-25">
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <i class="ficon" data-feather="bell"></i><span
            class="badge rounded-pill bg-danger badge-up">{{ $totalCount }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">{{ __('notifications.notifications') }}</h4>
                <div
                    class="badge rounded-pill badge-light-primary">{{ $totalCount }} {{ __('notifications.new') }}</div>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @if($totalCount)
                @if($visitsPending)
                    <a class="d-flex"
                       href="{{ route('appointment-listing') }}?from_date={{ date('Y-m-d') }}&status={{ \App\Enum\AppointmentStatus::pending }}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-success">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {{ __('notifications.total_pending_visits_head_message') }}
                                </p>
                                <small
                                    class="notification-text"> {{ __('notifications.you_have') }} {{ $visitsPending }} {{ __('notifications.total_pending_visits') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
                @if($visitsGroomingPending)
                    <a class="d-flex"
                       href="{{ route('appointmentGrooming-listing') }}?from_date={{ date('Y-m-d') }}&status={{ \App\Enum\AppointmentStatus::pending }}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-success">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="scissors"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {{ __('notifications.total_pending_grooming_visits_head_message') }}
                                </p>
                                <small
                                    class="notification-text"> {{ __('notifications.you_have') }} {{ $visitsGroomingPending }} {{ __('notifications.total_pending_grooming_visits') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
                @if($travelPending)
                    <a class="d-flex"
                       href="{{ route('travel-listing') }}?status={{ \App\Enum\TravelStatus::pending }}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-info">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="star"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {{ __('notifications.total_pending_travels_head_message') }}
                                </p>
                                <small
                                    class="notification-text"> {{ __('notifications.you_have') }} {{ $travelPending }} {{ __('notifications.total_pending_travels') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
                @if($travelRequestPending)
                    <a class="d-flex"
                       href="{{ route('travelRequest-listing') }}?status={{ \App\Enum\TravelRequestStatus::pending }}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-primary">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="send"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {{ __('notifications.total_pending_travel_requests_head_message') }}
                                </p>
                                <small
                                    class="notification-text"> {{ __('notifications.you_have') }} {{ $travelRequestPending }} {{ __('notifications.total_pending_travel_requests') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
                @if($joiningRequestPending)
                    <a class="d-flex"
                       href="{{ route('joiningRequest-listing') }}?status={{ \App\Enum\JoiningRequestStatus::pending }}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-warning">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="link"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {{ __('notifications.total_pending_joining_requests_head_message') }}
                                </p>
                                <small
                                    class="notification-text"> {{ __('notifications.you_have') }} {{ $joiningRequestPending }} {{ __('notifications.total_pending_joining_requests') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
            @else
                <a class="d-flex">
                    <div class="list-item d-flex align-items-start">
                        <div class="me-1">
                            <div class="avatar bg-light-danger">
                                <div class="avatar-content"><i class="avatar-icon" data-feather="x"></i></div>
                            </div>
                        </div>
                        <div class="list-item-body flex-grow-1">
                            <p class="media-heading">
                                {{ __('notifications.no_pending_visits_head_message') }}
                            </p>
                        </div>
                    </div>
                </a>
            @endif
        </li>
    </ul>
</li>

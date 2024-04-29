<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="{{$sitelang}}">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="{{url('/public/')}}">
    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/x-icon" href="logo_light_icon.png">
    <!-- BEGIN: Google Fonts -->
    {{--    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"--}}
    {{--          rel="stylesheet">--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
    <!-- END: Google Fonts-->
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors-{{$sitelang}}.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/toastr.min.css">
    <link rel="stylesheet" type="text/css"
          href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/apexcharts.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/plugins/charts/chart-apex.css">

    <link rel="stylesheet" type="text/css"
          href="app-assets/css-{{$sitelang}}/plugins/extensions/ext-component-toastr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/pages/app-invoice-list.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    @if($selected_lang == 'ar')
        <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/custom-{{$sitelang}}.css">
    @endif
    <link rel="stylesheet" type="text/css" href="assets/css/style-{{$sitelang}}.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css"
          href="app-assets/css-{{$sitelang}}/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/plugins/forms/pickers/form-pickadate.css">

    <link rel="stylesheet" type="text/css" href="app-assets/css-{{$sitelang}}/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/plugins/fontawesome/css/all.min.css">
    @stack('header')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="">
<!-- BEGIN: Header-->
@include('layouts.nav-header')

<!-- END: Header-->


<!-- BEGIN: Main Menu-->
@include('layouts.side-menu')
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    @include('layouts.alerts')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        @if(Route::currentRouteName() != 'home')
            <div class="content-header row">
                <div class="content-header-left mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-9">
                            <div class="breadcrumb-wrapper w-100">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a
                                            href="{{ url('') }}">{{trans('actor.home')}}</a>
                                    </li>
                                    @yield('breadcrumbs')
                                </ol>
                            </div>
                        </div>
                        <div class="col-3">
                            @yield('create-btn')
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-start d-block d-md-inline-block mt-25">
            <span>{{ __('dashboard.copyright') }}</span>
            <a class="ms-25">{{ '@ '.__('dashboard.project_title') }} </a>
            <span>&copy; {{ date('Y') }}</span>
        </span>
        <span class="float-md-end d-none d-md-block">{{ __('dashboard.dashboard_version') }}</span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button">
    <i data-feather="arrow-up"></i>
</button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>

<script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>

<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/vendors/js/extensions/toastr.min.js"></script>
<script src="app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="{{asset('app-assets/vendors/js/loadingoverlay/loadingoverlay.min.js')}}"></script>
{{--New--}}
<script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
<!-- END: Page Vendor JS-->

{{--<!-- BEGIN: Page JS-->--}}
{{--<script src="app-assets/js/scripts/forms/pickers/form-pickers.js"></script>--}}
<script src="app-assets/js/scripts/forms/form-select2.js"></script>
<!-- END: Page JS-->

<!-- BEGIN: Theme JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<script type="text/javascript">
    function callToastr(status, title, msg, time = 5000) {
        toastr[status](msg, title, {
            closeButton: true,
            tapToDismiss: true,
            timeOut: time, // miliseconds
            showMethod: 'slideDown',
            hideMethod: 'slideUp',
            enableHtml: true,
            rtl: 'ltr'
        });
    }

    function prepareErrors(response) {
        var errorsHtml = '<ul>';
        $.each(response.errors, function (key, value) {
            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        });
        errorsHtml += '</ul>';
        return errorsHtml;
    }

    function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return 1;
    }

    $(document).ready(function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }

        $('[data-toggle="tooltip"]').tooltip();

        $('.select2').select2({
            minimumResultsForSearch: Infinity
            // dir: "rtl",
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            statusCode: {
                404: function (XMLHttpRequest, textStatus, errorThrown) {
                    callToastr('error', '{{ trans('dashboard.toastr_error') }}', 'Page Not Found! Status: 404');
                },
                403: function (XMLHttpRequest, textStatus, errorThrown) {
                    callToastr('error', '{{ trans('dashboard.toastr_error') }}', 'Unauthenticated User, please refresh the page! Status: 403');
                },
                500: function (XMLHttpRequest, textStatus, errorThrown) {
                    callToastr('error', '{{ trans('dashboard.toastr_error') }}', 'Internal Server Error Status: 500');
                },
                422: function (XMLHttpRequest, textStatus, errorThrown) {
                    errorsHtml = prepareErrors(XMLHttpRequest.responseJSON);
                    callToastr('error', '{{ trans('dashboard.toastr_error') }}', errorsHtml);
                },
                305: function (XMLHttpRequest, textStatus, errorThrown) {
                    errorsHtml = prepareErrors(XMLHttpRequest.responseJSON);
                    callToastr('error', '{{ trans('dashboard.toastr_error') }}', XMLHttpRequest.responseJSON.message);
                }
            }
        });

        var bootstrapForm = $('.needs-validation');
        if (bootstrapForm.length) {
            Array.prototype.filter.call(bootstrapForm, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        form.classList.add('invalid');
                        event.preventDefault();
                    }
                    form.classList.add('was-validated');
                    var selectFocused = false;
                    $($(this).find('*[name]')).each(function (index) {
                        if (this.checkValidity() === false) {
                            if (!selectFocused) {
                                selectFocused = true;
                                $("html, body").animate({
                                    scrollTop: ($(this).offset().top - 150)
                                }, 1000);
                            }
                            $(this).addClass('invalid_field');
                        }
                    });
                });
                bootstrapForm.find('*[name]').on('change', function () {
                    $(this)
                        .removeClass('invalid_field')
                        .addClass(this.checkValidity() ? '' : 'invalid_field');
                });
            });
        }

        $("input[name='email']").on("input", function() {
            var email = $(this).val();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex for demonstration

            if (emailRegex.test(email)) {
                // Email format is valid
                $(this).removeClass('border-danger').addClass('border-success');
            } else {
                // Email format is invalid
                $(this).removeClass('border-success').addClass('border-danger');
            }
        });
    });
</script>
@stack('footer')
</body>
<!-- END: Body-->

</html>

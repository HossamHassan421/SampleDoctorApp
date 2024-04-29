@extends('layouts.master')
@section('title', trans('doctor.doctors'))
@push('header')
    @include('plugins.dialog.ui-css-dialog')
@endpush
@section('content')
    <!-- BEGIN: Content-->
    <div class="content-body">
        <!-- doctors list start -->
        <section>
        @include('doctor._filter')
        <!-- list section start -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @can('doctor-add')
                                <div class="d-inline">
                                    <a href="{{ route('doctor-create') }}" class="btn add-new btn-primary mt-50"
                                       type="button"><span>{{trans('doctor.create')}}</span></a>
                                </div>
                            @endcan
                            @can('doctor-download-excel')
                                <div class="d-inline">
                                    <form action="{{ route('doctor-download-excel') }}" method="POST"
                                          class="d-inline">
                                        @csrf
                                        @foreach(request()->all() as $name => $value)
                                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                        @endforeach
                                        <button class="btn btn-outline-secondary mt-50"
                                                type="submit">{{trans('doctor.download_excel')}}</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        @if(request('sort'))
                            <div class="col-6" style="text-align: end;">
                                <a class="btn btn-outline-secondary mt-50" id="remove_sort"
                                   type="button"><span>{{trans('system.remove_sort')}}</span></a>
                            </div>
                        @endif
                    </div>
                    <div class="card-datatable table-responsive pt-0 mb-1">
                        <table class="initDataTable table table-hover">
                            <thead class="thead-light">
                            <tr role="row">
                                <th>
                                    @sortablelink('id', '#')
                                    {!! sortIcon('id') !!}
                                </th>
                                {{--                                <th>{{trans('doctor.photo')}}</th>--}}
                                <th>
                                    @sortablelink('name', trans('doctor.name'))
                                    {!! sortIcon('name') !!}
                                </th>
                                <th>
                                    @sortablelink('mobile', trans('doctor.mobile'))
                                    {!! sortIcon('mobile') !!}
                                </th>
                                <th>
                                    @sortablelink('email', trans('doctor.email'))
                                    {!! sortIcon('email') !!}
                                </th>
                                <th>{{trans('doctor.is_active')}}</th>
                                <th>
                                    @sortablelink('created_at', trans('doctor.created_at'))
                                    {!! sortIcon('created_at') !!}
                                </th>
                                <th>{{trans('doctor.actions')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if ($data->isNotEmpty())
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->mobile }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{!! booleanFlagIcon($row->is_active) !!}</td>
                                        <td class="nowrap">
                                            {{  \Carbon\Carbon::parse($row->created_at)->locale(app()->getLocale())->isoFormat('YYYY-MM-DD hh:mmA') }}
                                        </td>
                                        <td>
                                            @canany(['doctor-edit','doctor-activation-toggle', 'doctor-show'])
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                            data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('doctor-edit')
                                                            <a class="dropdown-item"
                                                               href="{{ route('doctor-edit',$row->uuid) }}">
                                                                <i data-feather="edit-2" class="me-50"></i>
                                                                <span>{{trans('doctor.edit')}}</span>
                                                            </a>
                                                        @endcan
                                                        @can('doctor-activation-toggle')
                                                            <form method="POST"
                                                                  class='dropdown-item doctor-activation-toggle'
                                                                  action="{{ route('doctor-activation-toggle') }}">
                                                                @csrf
                                                                <input type="submit"
                                                                       id='activation-toggle{{ $row->uuid }}{{ $row->uuid }}'
                                                                       style="display:none">
                                                                <input type="hidden" name="uuid" value="{{$row->uuid}}">
                                                                <a onclick="document.getElementById('activation-toggle{{ $row->uuid }}{{ $row->uuid }}').click();"
                                                                   title='Activation Toggle'>
                                                                    <i class="me-50"
                                                                       data-feather='activity'></i>
                                                                    <span>
                                                                        @if($row->is_active)
                                                                            {{trans('doctor.deactivate')}}
                                                                        @else
                                                                            {{trans('doctor.activate')}}
                                                                        @endif
                                                                    </span>
                                                                </a>
                                                            </form>
                                                        @endcan
                                                        @can('doctor-show')
                                                            <a class="dropdown-item doctor_show"
                                                               link="{{ route('doctor-show',$row->uuid) }}">
                                                                <i data-feather="eye" class="me-50"></i>
                                                                <span>{{trans('doctor.show')}}</span>
                                                            </a>
                                                        @endcan
                                                        @if($row->email)
                                                            @can('doctor-reset-password')
                                                                <a class="dropdown-item doctor_reset_password"
                                                                   href="{{ route('doctor-reset-password',$row->uuid) }}">
                                                                    <i data-feather='edit' class="me-50"></i>
                                                                    <span>{{trans('doctor.reset_password')}}</span>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="odd">
                                    <td colspan="10"
                                        class="dataTables_empty">{{ trans('doctor.no_data_available_in_table') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $data->appends(request()->except('page'))->links('layouts.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- list section end -->
        </section>
        <!-- doctors list ends -->
    </div>
    @include('doctor.modals.show_modal')
    @include('doctor.modals.change_password_modal')

    @push('footer')
        @include('plugins.dialog.ui-js-dialog')
        @if($selected_lang == 'ar')
            <!-- Include the Arabic locale file for Flatpickr -->
            <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>

        @endif
        <script>
            $(function () {
                ui_form_dialog(".doctor-activation-toggle", '{{ trans('doctor.change_status_confirmation') }}');

                ui_anchor_dialog(".doctor_reset_password", '{{ trans('doctor.reset_password_confirmation') }}');

                $('.flatpickr-range').flatpickr({
                    mode: 'range',
                    maxDate: '{{ date('Y-m-d') }}',
                    @if($selected_lang == 'ar')
                    locale: 'ar',
                    @endif
                });

                $('.initDataTable').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    //"order": [[5, "desc"], [6, 'asc']],
                    "order": [0, "desc"],
                    "sScrollY": "450px",
                    "sScrollX": "100%",
                    // "sScrollXInner": "250%",
                    "bScrollCollapse": false,
                    @if($selected_lang == 'ar')
                    "language": {
                        "url": "{{asset('app-assets/vendors/js/tables/datatable/arabic.json')}}"
                    },
                    @endif
                    "fnDrawCallback": function () {
                        @if($data->total())
                        $("#DataTables_Table_0_info").parent().next().addClass('dataTables_info dataTables_info2').html('{{ __('datatables.total_records') . ": " . $data->total() . ' ' . __('datatables.records') }}')
                        @endif
                    }
                });

                $(document).on('click', '.doctor_show', function (e) {
                    var url = $(this).attr('link');
                    $("#showDoctorBody").html('');
                    $.ajax({
                        url: url,
                        method: 'POST',
                        async: true,
                        beforeSend: function () {
                            $.LoadingOverlay("show");
                        },
                        success: function (data) {
                            $("#showDoctorBody").html(data);
                            $('#showDoctorModal').modal('show');
                            $.LoadingOverlay("hide");
                        },
                        error: function (data) {
                            $.LoadingOverlay("hide");
                        }
                    });
                });

                $(document).on('click', '.doctor_change_password', function (e) {
                    $('#changePasswordForm input[class=form-control]').val('');
                    var uuid = $(this).attr('uuid');
                    $("#doctor_uuid").val(uuid);
                    $('#changePasswordModal').modal('show');
                });

                $(document).on('submit', '#changePasswordForm', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{route('doctor-change-password')}}',
                        method: 'POST',
                        data: $(this).serialize(),
                        async: true,
                        beforeSend: function () {
                            $.LoadingOverlay("show");
                        },
                        success: function (data) {
                            $.LoadingOverlay("hide");
                            $("#changePasswordModal").modal('hide');
                            callToastr('success', "{{ trans('dashboard.toastr_success') }}", '{{trans('doctor.updated_password_successfully')}}', 2000);
                        },
                        error: function (data) {
                            $.LoadingOverlay("hide");
                        }
                    });
                    return false;
                });

                var currentUrl = window.location.href;
                // Parse the URL to get its parameters
                var urlParams = new URLSearchParams(window.location.search);

                $("#remove_sort").click(function (e) {
                    urlParams.set('sort', '');
                    urlParams.set('direction', '');
                    // Generate the new URL with the updated parameters
                    window.location.href = currentUrl.split('?')[0] + '?' + urlParams.toString();
                });
            })
        </script>
    @endpush
    <!-- END: Content-->
@stop
@section('breadcrumbs')
    <li class="breadcrumb-item active">{{trans('doctor.doctors')}}</li>
@stop

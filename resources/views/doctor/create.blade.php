@extends('layouts.master')
@section('title', trans('doctor.create'))

@section('content')
    <div class="content-body">
        <section id="multiple-column-form">
            <div class="row">
                <form class="needs-validation" novalidate method='post' action="{{ route('doctor-add') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @include('doctor.form')
                    <div class="col-md-12">
                        <input type='submit' value='{{trans('doctor.save')}}' name='save'
                               class='btn btn-primary mr-1 waves-effect waves-float waves-light'>
                    </div>
                </form>
            </div>
        </section>
    </div>
@stop

@push('footer')
    @include('plugins.custom_js')
    <script>
        flatpickr("#start_date", {
            onChange: function (selectedDates, dateStr, instance) {
                // instance.set('minDate', selectedDates[0]);
                endDatePicker.set("minDate", selectedDates[0]);
            },
            minDate: '{{ date('Y-m-d') }}',
            allowInput: true,
            enableTime: false,
            @if($selected_lang == 'ar')
            locale: 'ar',
            @endif
        });
        var endDatePicker = flatpickr("#end_date", {
            minDate: '{{ date('Y-m-d') }}',
            allowInput: true,
            enableTime: false,
            @if($selected_lang == 'ar')
            locale: 'ar',
            @endif
        });
    </script>
@endpush

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('doctor-listing') }}">{{trans('doctor.doctors')}}</a></li>
    <li class="breadcrumb-item active">{{trans('doctor.create')}}</li>
@stop

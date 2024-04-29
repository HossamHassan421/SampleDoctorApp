<div class="row">
{{--    <div class="col-6 mb-1">--}}
{{--        <label class="form-label">{{trans('doctor.photo')}}</label>--}}
{{--        <div>--}}
{{--            @if($doctor->image)--}}
{{--                <img src="{{asset($doctor->image)}}" class="me-75"--}}
{{--                     alt="{{ $doctor['name'] }}"--}}
{{--                     width="50" height="50">--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="col-6 mb-1">
        <label class="form-label">{{trans('doctor.name')}}</label>
        <div>
            {{$doctor->name}}
        </div>
    </div>
    <div class="col-6 mb-1">
        <label class="form-label">{{trans('doctor.email')}}</label>
        <div>
            {{$doctor->email}}
        </div>
    </div>
    <div class="col-6 mb-1">
        <label class="form-label">{{trans('doctor.mobile')}}</label>
        <div>
            {{$doctor->mobile}}
        </div>
    </div>
    <div class="col-6 mb-1">
        <label class="form-label">{{trans('doctor.is_active')}}</label>
        <div>
            @if($doctor->is_active)
                <span class="text-success">{{ trans('doctor.activate') }}</span>
            @else
                <span class="text-danger">{{ trans('doctor.deactivate') }}</span>
            @endif
        </div>
    </div>

    <div class="col-6 mb-1">
        <label class="form-label">{{trans('doctor.created_at')}}</label>
        <div>
            {{  \Carbon\Carbon::parse($doctor->created_at)->locale(app()->getLocale())->isoFormat('YYYY-MM-DD hh:mmA') }}
        </div>
    </div>

    @if(isset($doctorSchedule) && $doctorSchedule)
        <div class="col-12 mb-1">
            <div class="divider">
                <div class="divider-text">{{trans('doctor.current_doctor_schedule')}}</div>
            </div>
        </div>

        <div class="col-4 mb-1">
            <label class="form-label" for="fp-range">{{trans('doctor.schedule_start_date')}}</label>
            <div>
                {{ $doctorSchedule->start_date }}
            </div>
        </div>

        <div class="col-4 mb-1">
            <label class="form-label" for="fp-range">{{trans('doctor.schedule_end_date')}}</label>
            <div>
                {{ $doctorSchedule->end_date }}
            </div>
        </div>

        <div class="col-4 mb-2">
            <label class="form-label" for="fp-range">{{trans('doctor.schedule_type')}}</label>
            <div>
                @if($doctorSchedule->schedule_type == 1)
                    <div>{{trans('doctor.schedule_type_one')}}</div>
                @elseif($doctorSchedule->schedule_type == 2)
                    <div>{{trans('doctor.schedule_type_two')}}</div>
                @elseif($doctorSchedule->schedule_type == 3)
                    <div>{{trans('doctor.schedule_type_three')}}</div>
                @elseif($doctorSchedule->schedule_type == 4)
                    <div>{{trans('doctor.schedule_type_four')}}</div>
                @endif
            </div>
        </div>
        @foreach($working_days as $day)
            <div class="row">
                <div class="col-2 mb-1">
                    <div>
                        {{ $day['name' . $lang] }}
                    </div>
                </div>
                <div class="col-10 mb-1">
                    <div>
                        @if($doctorSchedule->scheduleWorkingDays->contains('working_day_id', $day->id))
                            @foreach($doctorSchedule->scheduleWorkingDays as $workDay)
                                @if($day->id == $workDay->working_day_id)
                                    <span
                                        class="badge badge-light-success">{{ $workDay->workingHour['name' . $lang] }}</span>
                                @endif
                            @endforeach
                        @else
                            <span class="badge badge-light-danger">{{ __('doctor.day_off') }}</span>
                        @endif
                    </div>
                </div>
                <hr>
            </div>
        @endforeach
    @endif
</div>

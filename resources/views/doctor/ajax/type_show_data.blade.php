@foreach($working_days as $working_day)
    <div class="row mb-1">
        <div class="col-3 mb-1">
            <label class="form-label">&nbsp;</label>
            <div class="form-group">
                <div class="form-check-primary form-switch">
                    <input name="working_schedule[{{$working_day->id}}]" type="checkbox" class="form-check-input"
                           id="{{$working_day['id']}}"
                           onchange="toggleSelect({{$working_day['id']}},{{$loop->index}})"
                           @if(isset($doctorSchedule) && $doctorSchedule
                            && $doctorSchedule->scheduleWorkingDays->contains('working_day_id', $working_day->id)) checked @endif>
                    <label class="form-check-label"
                           for="{{$working_day['id']}}">&nbsp;&nbsp;{{$working_day['name'. $lang]}}</label>
                </div>
            </div>
        </div>

        <div class="col-9 mb-1">
            <label class="form-label"
                   for="{{ $working_day['id'].$loop->index }}">{{trans('doctor.choose_working_hours')}}
                <span class="text-danger">*</span></label>
            <select @if(isset($doctorSchedule) && $doctorSchedule
                    && $doctorSchedule->scheduleWorkingDays->contains('working_day_id', $working_day->id)) @else disabled=""
                    @endif class="select2 form-select"
                    name="working_schedule[{{$working_day->id}}][]"
                    id="{{  $working_day['id'].$loop->index }}"
                    multiple>
                @foreach($working_hours as $val)
                    <option
                        <?php
                        if(isset($doctorSchedule) && $doctorSchedule) {
                            $selectedData = $doctorSchedule->scheduleWorkingDays->filter(function ($item) use ($val, $working_day) {
                                if ($item->working_day_id == $working_day->id && $item->working_hour_id == $val->id) {
                                    return true;
                                }
                            });
                        }
                        ?>
                        @if(isset($doctorSchedule) && $doctorSchedule
                        && $selectedData->contains('working_day_id', $working_day->id)
                        && $selectedData->contains('working_hour_id', $val->id))
                        selected
                        @endif
                        value="{{ $val->id }}">{{ $val['name'. $lang] }}</option>
                @endforeach
            </select>
            {!! $errors->first('working_days', '<p class="text-danger">:message</p>') !!}
        </div>
    </div>
@endforeach
<script>
    // if ($('select').data('select2')) {
    //     $('select').select2('destroy');
    // }
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

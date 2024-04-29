<div class="col-12 mb-1">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{trans('doctor.basic_information')}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <input type='hidden' value='{{$model->uuid}}' name='uuid'>
                <div class="col-6 mb-1">
                    <div class="form-group">
                        <label class="form-label">{{trans('doctor.name')}} <span class="text-danger">*</span></label>
                        <input type="text" name='name'
                               class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}"
                               value='{{ old('name', $model->name) }}' required>
                        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    </div>
                </div>

                <div class="col-6 mb-1">
                    <div class="form-group">
                        <label class="form-label">{{trans('doctor.email')}} <span class="text-danger">*</span></label>
                        <input type="email" name='email'
                               class="form-control {{ $errors->has('email') ? 'border-danger' : '' }}"
                               value='{{ old('email', $model->email) }}' required>
                        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    </div>
                </div>

                <div class="col-6 mb-1">
                    <div class="form-group">
                        <label class="form-label">{{trans('doctor.mobile')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-merge mb-2">
                            @if($sitelang=='ltr')
                                <span class="input-group-text" style="direction: ltr;">+966</span>
                            @endif
                            <input type="number" name='mobile'
                                   class="saudiNumber form-control {{ $errors->has('mobile') ? 'border-danger' : '' }}"
                                   value='{{ old('mobile', $model->mobile) }}'
                                   required minlength="9" maxlength="9">
                            @if($sitelang=='rtl')
                                <span class="input-group-text" style="direction: ltr;">+966</span>
                            @endif
                        </div>
                        {!! $errors->first('mobile', '<p class="text-danger">:message</p>') !!}
                    </div>
                </div>
                <div class="col-6 mb-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-group">
                        <div class="form-check-primary form-switch">
                            <input type="hidden" name='is_active' value='0'>
                            <input autocomplete="off" name="is_active" type="checkbox" class="form-check-input"
                                   id="is_active" @if(old('is_active', $model->is_active) === 0) @else checked
                                   @endif value="1">
                            <label class="form-check-label"
                                   for="is_active">&nbsp; {{ __('doctor.is_active') }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-1">
                    <div class="form-group">
                        <label class="form-label">{{trans('doctor.doctor_percentage_fees')}} <span class="text-danger">*</span></label>
                        <input type="text" name='doctor_percentage_fees'
                               class="form-control max_100_number {{ $errors->has('doctor_percentage_fees') ? 'border-danger' : '' }}"
                               value='{{ old('doctor_percentage_fees', $model->doctor_percentage_fees) }}' required>
                        {!! $errors->first('doctor_percentage_fees', '<p class="text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!isset($edit))
    <div class="col-12 mb-1">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{trans('doctor.create_doctor_schedule')}}</h4>
            </div>
            <div class="card-body">

                <div class="row mb-1">
                    <div class="col-md-4 mb-1">
                        <label class="form-label" for="fp-range">{{trans('doctor.schedule_start_date')}}
                            <span class="text-danger">*</span></label>
                        <input autocomplete="off" required id="start_date" type="text" name="start_date"
                               class="form-control required"
                               value=''/>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label class="form-label" for="fp-range">{{trans('doctor.schedule_end_date')}}
                            <span class="text-danger">*</span></label>
                        <input autocomplete="off" required id="end_date" type="text" name="end_date"
                               class="form-control required"
                               value=''/>
                    </div>
                    <div class="col-4 mb-1">
                        <label class="form-label" for="is_active">{{trans('doctor.schedule_type')}}
                            <span class="text-danger">*</span></label>
                        <select autocomplete="off" required link="{{ route('doctor-schedule-type-show')}}"
                                class="form-select type_show_data" name="schedule_type" id="type_show_data">
                            <option selected value="">{{trans('doctor.choose')}}</option>
                            <option class="text-muted" disabled value="1">{{trans('doctor.schedule_type_one')}}</option>
                            <option value="2">{{trans('doctor.schedule_type_two')}}</option>
                            <option class="text-muted" disabled value="3">{{trans('doctor.schedule_type_three')}}</option>
                            <option class="text-muted" disabled value="4">{{trans('doctor.schedule_type_four')}}</option>
                        </select>
                    </div>
                </div>

                <div id="sectionToUpdate">
                    <!-- This is the section that will be updated dynamically -->
                </div>

            </div>
        </div>
    </div>
@endif


@push('footer')
    <script>
        @if(!isset($edit))
        function toggleSelect(id, loopIndex) {
            var checkbox = document.getElementById(id);
            var numbersAsString = `${id}${loopIndex}`;
            var select = document.getElementById(numbersAsString);

            if (checkbox.checked) {
                select.disabled = false;
                $(select).attr('required', 'required');
            } else {
                select.disabled = true;
                $(select).removeAttr('required');
            }
            $(select).val('').select2();
        }

        $(document).on('change', '.type_show_data', function (e) {
            var url = $(this).attr('link');
            var selectedValue = $(this).val();
            $.ajax({
                url: url,
                method: 'POST',
                data: {type: selectedValue},
                async: true,
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    $(".select2").select2();
                    $("#sectionToUpdate").html('').html(data);
                    $.LoadingOverlay("hide");
                },
                error: function (data) {
                    $.LoadingOverlay("hide");
                }
            });
        });
        @endif
    </script>
@endpush

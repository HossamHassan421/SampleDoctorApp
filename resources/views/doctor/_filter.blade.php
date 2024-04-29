<div class="card">
    <div class="card-header pb-25 pt-25">
        <button class="pe-0 ps-0 font-medium-3 accordion-button collapsed" data-bs-toggle="collapse"
                data-bs-target="#searchDiv">
            <i class="font-medium-3 rotate-90" data-feather='sliders'></i>&nbsp; {{trans('doctor.filters')}}
        </button>
    </div>
    <form method='get' class='search'>
        <div id="searchDiv" class="card-body collapse">
            <div class="row">
                {{--inputs start--}}
                <div class="col-4 mb-1">
                    <div class="form-group mb-0">
                        <label class="form-label">{{trans('doctor.name')}}</label>
                        <input type="text" name='name' value='{{ request('name') }}' class="form-control">
                    </div>
                </div>
                <div class="col-4 mb-1">
                    <div class="form-group mb-0">
                        <label class="form-label">{{trans('doctor.email')}}</label>
                        <input type="text" name='email' value='{{ request('email') }}' class="form-control">
                    </div>
                </div>
                <div class="col-4 mb-1">
                    <div class="form-group mb-0">
                        <label class="form-label">{{trans('doctor.mobile')}}</label>
                        <input type="text" name='mobile' value='{{ request('mobile') }}' class="form-control">
                    </div>
                </div>
                <div class="col-4 mb-1">
                    <label class="form-label" for="is_active">{{trans('doctor.is_active')}}</label>
                    <select class="form-select" name="is_active" id="is_active">
                        <option value="">{{trans('doctor.choose')}}</option>
                        <option @if(request()->has('is_active')&&request('is_active')==1) selected
                                @endif value="1">{{trans('doctor.activated')}}</option>
                        <option @if(request()->has('is_active')&&request('is_active')==='0') selected
                                @endif value="0">{{trans('doctor.deactivated')}}</option>
                    </select>
                </div>

                <div class="col-md-4 mb-1">
                    <label class="form-label" for="fp-range">{{trans('doctor.created_at')}}</label>
                    <input id="created_at_range" type="text" name="created_at" class="form-control flatpickr-range"
                           value='{{ request('created_at') }}'/>
                </div>
                {{--inputs End--}}

                <div class="col-12">
                    <button class="search btn btn-primary waves-effect" name='search' type="submit">
                        <span>{{trans('doctor.filters')}}</span></button>
                    <a href="{{ route('doctor-listing') }}" class="btn btn-outline-secondary waves-effect"
                       type="button"><span>{{trans('doctor.reset_filters')}}</span></a>
                </div>
            </div>
        </div>

    </form>
</div>

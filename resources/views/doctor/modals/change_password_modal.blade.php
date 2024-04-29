<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h3 class="text-center mb-1">{{ trans('doctor.are_you_sure_change_password') }}</h3>
                <!--                <p class="text-center"></p>-->

                <!-- form -->
                <form id="changePasswordForm" class="row gy-1 gx-2 mt-75" method='post'
                      action="{{ route('doctor-change-password') }}">
                    @csrf
                    <input type="hidden" name='uuid' id="doctor_uuid">
                    <div class="row">
                        <div class="form-group col-md-6 mb-1">
                            <label class="form-label">{{trans('doctor.password')}}</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input required type="password" class="form-control form-control-merge"
                                       id="password" name="password" tabindex="2"
                                       placeholder=""
                                       aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="form-label">{{trans('doctor.password_confirmation')}}</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input required type="password" class="form-control form-control-merge"
                                       id="password_confirmation" name="password_confirmation" tabindex="2"
                                       placeholder=""
                                       aria-describedby="password_confirmation"/>
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-1 mt-1">{{ trans('doctor.yes') }}</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                aria-label="Close">
                            {{ trans('doctor.no') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

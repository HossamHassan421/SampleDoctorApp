<div class="modal fade" id="showDoctorModal" tabindex="-1" aria-labelledby="addScoreModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h3 class="text-center mb-1">{{ trans('doctor.show_doctor_data') }}</h3>
                <!--                <p class="text-center"></p>-->

                <!-- form -->
                {{--                <form id="addScoreForm" class="row gy-1 gx-2 mt-75" onsubmit="return false">--}}
                <div class="col-12" id="showDoctorBody">

                </div>
                <div class="col-12 text-center">
                    {{--                        <button type="submit" class="btn btn-primary me-1 mt-1">حفظ</button>--}}
                    <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                            aria-label="Close">
                        {{ trans('doctor.close') }}
                    </button>
                </div>
                {{--                </form>--}}
            </div>
        </div>
    </div>
</div>

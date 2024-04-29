<?php

namespace App\Http\Controllers;

use App\Exports\DoctorExport;
use App\Http\Requests\Doctor\ActivationRequest;
use App\Http\Requests\Doctor\ChangePassword;
use App\Http\Requests\Doctor\EditRequest;
use App\Http\Requests\Doctor\AddRequest;
use App\Models\Doctor;
use App\Models\WorkingDay;
use App\Models\WorkingHour;
use App\Services\DoctorService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DoctorController extends Controller
{
    /**
     * Listing all doctors
     * @param Doctor $model
     * @param Request $request
     * @return mixed
     */
    public function listing(Doctor $model, Request $request)
    {
        // Handle the delimiter of date range string ex: (to | إالى)
        changeDelimiterInDateRange($request, 'created_at');
        $data['data'] = DoctorService::listing($model, $request);
        return view('doctor.listing', $data);
    }

    /**
     * Create form to register new doctor
     * @param Doctor $model
     * @param Request $request
     * @return mixed
     */
    public function create(Doctor $model, Request $request)
    {
        $data['model'] = $model;
        return view('doctor.create', $data);
    }

    /**
     * Register new doctor
     * @param AddRequest $request to validate the request data
     * @return mixed
     * @throws \Exception
     */
    function add(AddRequest $request)
    {
        DoctorService::create($request->all());
        session()->flash('msg', trans('dashboard.created_successfully'));
        return redirect()->route('doctor-listing');
    }

    /**
     * Change password of doctor
     * @param ChangePassword $request to validate the request data
     * @throws \Exception
     */
    public function changePassword(ChangePassword $request)
    {
        DoctorService::changePassword($request);
    }

    /**
     * Reset password of selected doctor
     * @param $uuid // of the selected doctor
     * @param Request $request to validate the request data
     * @return mixed
     * @throws \Exception
     */
    public function resetPassword($uuid, Request $request)
    {
        $request->merge(['uuid' => $uuid]);
        $request->validate([
            'uuid' => 'required|max:36',
        ]);
        $doctor = Doctor::where('uuid', $request->uuid)->firstOrFail();
        if($doctor->email) {
            DoctorService::resetPassword($doctor);
            session()->flash('msg', trans('dashboard.email_sent_successfully'));
        } else {
            session()->flash('error', trans('doctor.doctor_does_not_have_email'));
        }
        return redirect()->back();
    }

    /**
     * Download the doctors list
     * @param Request $request to validate the request data
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadExcel(Request $request)
    {
        changeDelimiterInDateRange($request, 'created_at');
        return Excel::download(new DoctorExport($request), "doctors" . ".xlsx");
    }

    /**
     * Edit the selected doctor
     * @param $uuid // of the selected doctor
     * @return mixed
     */
    public function edit($uuid)
    {
        $data['model'] = DoctorService::edit($uuid);
        $data['edit'] = true;
        return view('doctor.edit', $data);
    }


    /**
     * Update the selected doctor
     * @param EditRequest $request to validate the request data
     * @return mixed
     * @throws \Exception
     */
    public function update(EditRequest $request)
    {
        DoctorService::update($request);
        session()->flash('msg', trans('dashboard.updated_successfully'));
        return redirect()->route('doctor-listing');
    }

    /**
     * Change the selected doctor status (active | inactive)
     * @param ActivationRequest $request to validate the request data
     * @return mixed
     */
    function activationToggle(ActivationRequest $request)
    {
        DoctorService::activationToggle($request);
        session()->flash('msg', trans('dashboard.updated_successfully'));
        return redirect()->back();
    }


    /**
     * Show info for selected doctor
     * @param $uuid // of the selected doctor
     * @param Request $request to validate the request data
     * @return mixed
     */
    public function show($uuid, Request $request)
    {
        $request->merge(['getFirst' => true, 'uuid' => $uuid]);
        $request->validate([
            'uuid' => 'required|max:36',
        ]);
        $doctor = DoctorService::getByData(new Doctor(), $request);
        $doctorSchedule = Doctor::getCurrentActiveSchedule($doctor);
        $working_days = WorkingDay::all();
        return view('doctor.ajax.show_data', compact('doctor', 'doctorSchedule', 'working_days'))->render();
    }
}

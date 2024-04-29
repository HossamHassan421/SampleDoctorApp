<?php


namespace App\Exports;

use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DoctorExport implements FromView, ShouldAutoSize
{
    public $request = '';

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $doctors = DoctorService::listingAll(new Doctor(), $this->request);
        return view('doctor.excel', [
            'doctors' => $doctors,
        ]);
    }
}

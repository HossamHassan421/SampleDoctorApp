<?php


namespace App\Exports;

use App\Services\DoctorScheduleService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DoctorScheduleExport implements FromView, ShouldAutoSize
{
    public $request = '';

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $data = DoctorScheduleService::listingAll($this->request);
        return view('doctorSchedule.excel', [
            'data' => $data,
        ]);
    }
}

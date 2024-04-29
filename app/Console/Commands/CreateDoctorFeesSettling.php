<?php

namespace App\Console\Commands;

use App\Services\DoctorService;
use Illuminate\Console\Command;

class CreateDoctorFeesSettling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:doctor-fees-settling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate monthly invoices of appointments for doctors and groomers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DoctorService::createFeesSettlingByDates(date('Y-m-d H:i:s'));
    }
}

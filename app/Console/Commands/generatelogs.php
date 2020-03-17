<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Device_Employee;
use Ixudra\Curl\Facades\Curl;
use App\MemberEnrollment;
use App\HRDeviceevent;
use App\HRDeviceseqcount;
use App\Employee;
use App\Actionlog;
use App\HR_device_emplog;

class generatelogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generatelogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle(Request $request)
    {
       
		$employeeid = '';
		$months = 1;
        $year = date('Y');
        $employee = Employee::where('status', 1)->get()->all();
        for ($month=1; $month <= 3 ; $month++) { 
       
            foreach ($employee as $key => $value) {
                $employeeid=$value->employeeid;

                if($employeeid && $month && $year){

                    $empdetail = Employee::where('employeeid', $employeeid)->first();
                    $cal_month=$month;
                

                    $day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
                    $fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
                    $todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));

                    for($i = 1; $i<= $day_in_month; $i++){

                        $current_date = date('Y-m-d',strtotime("$year-$cal_month-$i"));
                    
                        $excel = new HR_device_emplog();
                        $current_date;
                        $excel->dateid = $current_date;
                        $excel->empid = $employeeid;
                        $excel->timein1 = '';
                        $excel->timeout1 = '';
                        $excel->timein2 = '';
                        $excel->timeout2 = '';
                        $excel->timein3 = '';
                        $excel->timeout3 = '';
                        $excel->status = 0;
                        $excel->save();

                    }
                
                }
                echo 'Employee Logs Generated Succesfully for Employeeid' .$employeeid.'<br>';
            }
        }
	}
    
}

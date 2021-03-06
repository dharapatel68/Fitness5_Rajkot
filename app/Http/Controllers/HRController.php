<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkingDays;
use App\Leave;
use App\EmployeeAccount;
use App\Employee;
use App\User_log;
use App\HREmployeeelog;
use App\Salary;
use App\EmployeeLeave;
use App\MonthLeave;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Helper;
use DB;
use Session;
use Datatables;
use App\Ptassignlevel;
use App\Ptmember;
use App\Member;
use App\Claimptsession;
use App\MemberPackages;
use App\ExcelExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\HR_device_emplog;
use Carbon\Carbon;
class HRController extends Controller
{
    
	/////////////////////////////////////////// Working Days Start ////////////////////////////////////////////////////////

	public function workingdays(Request $request){


		if($request->isMethod('post')){

			$request->validate([

				'year' => 'required',
				'month' => 'required',
				'workingdays' => 'required|integer',

			]);

		DB::beginTransaction();
		 try {

			$year = $request->year;
			$month = $request->month;
			$workingdays = $request->workingdays;
			$nonworkingdats = !empty($request->nonworkingdate) ? $request->nonworkingdate : [];

			$nonworgdayscount = count($nonworkingdats);

			$month_exist = WorkingDays::where('year', $year)->where('month', $month)->get()->all();

			if(!empty($month_exist)){
				return redirect()->back()->with('error', 'Month already Exist')->withInput(Input::all());
			}

			if($request->month == 'Janaury'){
				$cal_month = 1;
			}else if($request->month == 'February'){
				$cal_month = 2;
			}else if($request->month == 'March'){
				$cal_month = 3;
			}else if($request->month == 'April'){
				$cal_month = 4;
			}else if($request->month == 'May'){
				$cal_month = 5;
			}else if($request->month == 'June'){
				$cal_month = 6;
			}else if($request->month == 'July'){
				$cal_month = 7;
			}else if($request->month == 'August'){
				$cal_month = 8;
			}else if($request->month == 'September'){
				$cal_month = 9;
			}else if($request->month == 'October'){
				$cal_month = 10;
			}else if($request->month == 'November'){
				$cal_month = 11;
			}else{
				$cal_month = 12;
			}

			$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);

			$holiday_cal = $day_in_month - $nonworgdayscount; 

			$workingdays_obj = new WorkingDays();
			$workingdays_obj->year = $year;
			$workingdays_obj->month = $request->month;
			$workingdays_obj->holidays = $nonworgdayscount;
			$workingdays_obj->workingdays = $holiday_cal;
			$workingdays_obj->save();

			$working_days_id = $workingdays_obj->workingcalid;

			if($nonworgdayscount > 0){
				foreach($nonworkingdats as $nondate){
					if(!empty($nondate)){
						$nondateins = new MonthLeave();
						$nondateins->workingcalanderid = $working_days_id;
						$nondateins->nonworkingdate = date('Y-m-d', strtotime($nondate));
						$nondateins->action_by = session()->get('admin_id');
						$nondateins->save();
					}
				}
			}
			
			DB::commit();
			$success = true;

			Session::flash('message', 'Working days is added successfully');
    		Session::flash('alert-type', 'success');

			return redirect()->route('viewworkingdays');

		 } catch (\Exception $e) {
          Helper::errormail('HR', 'Add Workingdays', 'High');
          $success = false;
          DB::rollback();

        }
        
        if ($success == false) { 
          return redirect('dashboard');
        }


		}


		return view('hr.workingdays.addworkingdays');

	}

	public function viewworkingdays(){

		$working_days = WorkingDays::paginate(10);

		return view('hr.workingdays.viewworkingdays', compact('working_days'));



	}

	public function editworkingdays($id, Request $request){

		$working_days = WorkingDays::with('nonworkingdays')->where('workingcalid',$id)->first();

		if($request->isMethod('post')){


			$request->validate([

				'year' => 'required',
				'month' => 'required',
				'workingdays' => 'required|integer',

			]);

		DB::beginTransaction();
		try {
			$year = $request->year;
			$month = $request->month;
			$workingdays = $request->workingdays;
			$nonworkingdats = !empty($request->nonworkingdate) ? $request->nonworkingdate : [];
			
			$nonworgdayscount = count($nonworkingdats);

			$month_exist = WorkingDays::where('year', $year)->where('month', $month)->where('workingcalid' ,'!=', $id)->get()->all();

			if(!empty($month_exist)){
				return redirect()->back()->with('error', 'Month already Exist')->withInput(Input::all());
			}

			if($request->month == 'Janaury'){
				$cal_month = 1;
			}else if($request->month == 'February'){
				$cal_month = 2;
			}else if($request->month == 'March'){
				$cal_month = 3;
			}else if($request->month == 'April'){
				$cal_month = 4;
			}else if($request->month == 'May'){
				$cal_month = 5;
			}else if($request->month == 'June'){
				$cal_month = 6;
			}else if($request->month == 'July'){
				$cal_month = 7;
			}else if($request->month == 'August'){
				$cal_month = 8;
			}else if($request->month == 'September'){
				$cal_month = 9;
			}else if($request->month == 'October'){
				$cal_month = 10;
			}else if($request->month == 'November'){
				$cal_month = 11;
			}else{
				$cal_month = 12;
			}

			$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);

			$workingdays = $day_in_month - $nonworgdayscount;

			$holiday_cal = $day_in_month - $workingdays; 

			$workingdays_obj = WorkingDays::findOrfail($id);
			$workingdays_obj->year = $year;
			$workingdays_obj->month = $request->month;
			$workingdays_obj->holidays = $nonworgdayscount;
			$workingdays_obj->workingdays = $workingdays;
			$workingdays_obj->save();

			$working_days_id = $workingdays_obj->workingcalid;

			$working_days = MonthLeave::where('workingcalanderid', $working_days_id)->get()->all();
			if(!empty($working_days)){
				foreach($working_days as $days){
					$nonworkdate = MonthLeave::findOrfail($days->monthleaveid);
					if(!empty($nonworkdate)){
						$nonworkdate->delete();
					}
				}
			} 

			if($nonworgdayscount > 0){
				foreach($nonworkingdats as $nondate){
					if(!empty($nondate)){
						$nondateins = new MonthLeave();
						$nondateins->workingcalanderid = $working_days_id;
						$nondateins->nonworkingdate = date('Y-m-d', strtotime($nondate));
						$nondateins->action_by = session()->get('admin_id');
						$nondateins->save();
					}
				}
			}

			DB::commit();
			$success = true;

			Session::flash('message', 'Working days is added successfully');
    		Session::flash('alert-type', 'success');

			return redirect()->route('viewworkingdays');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Edit Workingdays', 'High');
			DB::rollback();
			$success = false;

		}

		if ($success == false) { 
          return redirect('dashboard');
        }


		}

		return view('hr.workingdays.editworkingdays', compact('working_days'));



	}

	public function searchyear(Request $request){

		$year = $request->year;

		$working_days = WorkingDays::where('year', $year)->orderBy('workingcalid', 'asc')->paginate(10);

		return view('hr.workingdays.viewworkingdays', compact('working_days', 'year'));
	}

	/////////////////////////////////////////// Working Days End   ////////////////////////////////////////////////////////



	/////////////////////////////////////////// Leave Start   ////////////////////////////////////////////////////////


	public function leave(Request $request){


		if($request->isMethod('post')){


			$request->validate([

				'employeeid' => 'required|unique:hr_leave,employeeid',
				'noofleave' => 'required|integer',
				'expirydate' => 'required|date',

			]);

		DB::beginTransaction();
		try {
			$Leave_obj = new Leave();
			$Leave_obj->employeeid = $request->employeeid;
			$Leave_obj->noofleave = $request->noofleave;
			$Leave_obj->expirydate = date('Y-m-d', strtotime($request->expirydate));
			$Leave_obj->actionby = session()->get('admin_id');
			$Leave_obj->save();

			DB::commit();
			$success = true;

			Session::flash('message', 'Leave is added successfully');
    		Session::flash('alert-type', 'success');
			return redirect()->route('viewleave');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Add Leave', 'High');
			DB::rollback();
			$success = false;

		}

		if($success == false){
			return redirect('dashboard');
		}


		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('hr.leave.addleave', compact('employee'));

	}

	public function viewleave(){

		$Leave = Leave::with('employeename')->paginate(10);
		$employee = Employee::where('status', 1)->get()->all();
		//dd($Leave);
		return view('hr.leave.viewleave', compact('Leave', 'employee'));

	}

	public function searcheleave(Request $request){

		$empid = $request->employeeid;

		$Leave = Leave::with('employeename')->where('employeeid', $empid)->paginate(10);
		$employee = Employee::where('status', 1)->get()->all();
		
		return view('hr.leave.viewleave', compact('Leave', 'employee'));
	}

	public function editleave($id, Request $request){

		$Leave_obj = Leave::findOrfail($id);


		if($request->isMethod('post')){


			$request->validate([

				'employeeid' => ['required', Rule::unique('hr_leave')->ignore($id, 'leaveid')],
				'noofleave' => 'required|integer',
				'expirydate' => 'required|date',

			]);

		DB::beginTransaction();
		try {
			$Leave_obj->employeeid = $request->employeeid;
			$Leave_obj->noofleave = $request->noofleave;
			$Leave_obj->expirydate = date('Y-m-d', strtotime($request->expirydate));
			$Leave_obj->actionby = session()->get('admin_id');
			$Leave_obj->save();

			DB::commit();
			$success = true;

			Session::flash('message', 'Leave is edited successfully');
    		Session::flash('alert-type', 'success');
			return redirect()->route('viewleave');


		} catch(\Exception $e){
			Helper::errormail('HR', 'Edit Leave', 'High');
			DB::rollback();
			$success = false;

		}

		if($success == false){
			return redirect('dashboard');
		}

		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('hr.leave.editleave', compact('Leave_obj', 'employee'));

	}

	public function searchleaveyear(Request $request){

		$year = $request->year;

		$Leave = Leave::where('leaveyear', $year)->orderBy('leaveid', 'asc')->get()->all();

		return view('hr.leave.viewleave', compact('Leave', 'year'));
	}

	/////////////////////////////////////////// Leave End   ////////////////////////////////////////////////////////

	//////////////////////////////////////////// Employee Acoount Start /////////////////////////////////////////////

	public function employeeaccount(Request $request){

		if($request->isMethod('post')){


			$request->validate([

				'employeeid' => 'required',
				'amount' => 'required|integer',
				'type' => 'required',

			]);

		DB::beginTransaction();
		try {

			$pastrecord = EmployeeAccount::where('employeeid', $request->employeeid)->orderBy('empaccountid', 'desc')->first();
			if(!empty($pastrecord)){
				$amountcal = $pastrecord->amount;
			} else {
				$amountcal = 0;
			}

			if($request->type == 'Loan'){

				$amount = $amountcal + $request->amount;

			}else{

				if($amountcal == 0){

					Session::flash('message', 'No loan found');
    				Session::flash('alert-type', 'error');

					return redirect()->back();
				}

				$amount = $amountcal - $request->amount;

				if($amount < 0){

					Session::flash('message', 'Please add valid amount');
    				Session::flash('alert-type', 'error');

					return redirect()->back();
				}
			}

			$employeeaccount = new EmployeeAccount();
			$employeeaccount->employeeid = $request->employeeid;
			$employeeaccount->amount = $amount;
			$employeeaccount->type = $request->type;
			$employeeaccount->empaccountdate = date('Y-m-d h:i:s');
			$employeeaccount->actionby = session()->get('admin_id');
			$employeeaccount->save();

			$salary = Salary::where('employeeid', $request->employeeid)->where('ispaid', 0)->orderBy('salaryid', 'desc')->first();
			if(!empty($salary)){

				$emi = $salary->salaryemi;
				$currentsalary = $salary->currentsalary;

				$updateemi = $emi - $request->amount;
				$updatesalary = $currentsalary + $request->amount;

				$salary->salaryemi = $updateemi;
				$salary->currentsalary = $updatesalary;

				$salary->save();

			}

			DB::commit();
			$success = true;

			Session::flash('message', 'Amount is added successfully');
    		Session::flash('alert-type', 'success');

			return redirect()->route('viewemployeeaccount');

		} catch(\Exception $e) {
		  Helper::errormail('HR', 'Add Employeeaccount', 'High');
		  $success = false;
          DB::rollback();

		}

		if ($success == false) { 
          return redirect('dashboard');
        }

		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('hr.account.addemployeeamount', compact('employee'));


	}

	public function viewemployeeaccount(){

		$account = EmployeeAccount::with('employeename')->paginate(10);
		$employee = Employee::where('status', 1)->get()->all();
		return view('hr.account.viewemployeeamount')->with(compact('account', 'employee'));

	}

	public function searchemployeeaccount(Request $request){

		$empid = $request->employeeid;

		$account = EmployeeAccount::with('employeename')->where('employeeid', $empid)->paginate(10);
		$employee = Employee::where('status', 1)->get()->all();


		return view('hr.account.viewemployeeamount')->with(compact('account', 'employee', 'empid'));


	}

	//////////////////////////////////////////// Employee Acoount End   /////////////////////////////////////////////


	//////////////////////////////////////////// Employee Log Start //////////////////////////////////////////////

	public function employeelog(){

		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeelog.viewemployeelog')->with(compact('employee'));

	}

	public function searchemployeelog(Request $request){
		if ($request->ajax()) {

		$employeeid = $request->employeeid;
		$year = $request->year;
		$month = $request->month;

		if(!empty($employeeid) || !empty($year) || !empty($month)){

		if($request->month == 'Janaury'){
			$cal_month = 1;
		}else if($request->month == 'February'){
			$cal_month = 2;
		}else if($request->month == 'March'){
			$cal_month = 3;
		}else if($request->month == 'April'){
			$cal_month = 4;
		}else if($request->month == 'May'){
			$cal_month = 5;
		}else if($request->month == 'June'){
			$cal_month = 6;
		}else if($request->month == 'July'){
			$cal_month = 7;
		}else if($request->month == 'August'){
			$cal_month = 8;
		}else if($request->month == 'September'){
			$cal_month = 9;
		}else if($request->month == 'October'){
			$cal_month = 10;
		}else if($request->month == 'November'){
			$cal_month = 11;
		}else{
			$cal_month = 12;
		}

		$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
		$fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
		$todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));
		
		$searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];

		$employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->orderBy('timeout1', 'asc')->get();
	
		return datatables()->of($employeelog)
		->editColumn('timeout1', function($employeelog){
			if(!empty($employeelog->timeout1)){
				return $employeelog->timeout1;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})

		->editColumn('timein2', function($employeelog){
			if(!empty($employeelog->timein2)){
				return $employeelog->timein2;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})
		->editColumn('timeout2', function($employeelog){
			if(!empty($employeelog->timeout2)){
				return $employeelog->timeout2;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}
			
		})
		->editColumn('timein3', function($employeelog){
			if(!empty($employeelog->timein3)){
				return $employeelog->timein3;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}
			
		})
		->editColumn('timeout3', function($employeelog){
			if(!empty($employeelog->_)){
				return $employeelog->_;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}
			
		})->escapeColumns([])
		->make(true);

		//$employee = Employee::where('status', 1)->get()->all();


		//$employeelog->appends(array('employeeid' => $employeeid, 'year' => $year, 'month' => $month));

		
		//return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employeelog', 'employee', 'searchparameter'));

		}
	}
	}


	public function addpunch($id, Request $request){

		$log = HREmployeeelog::findOrfail($id);

		if($request->isMethod('post')){

			$request->validate([

				'punchtime' => 'required',


			]);

			$checkout = $request->punchtime;
			$checkin = $log->checkin;

			DB::beginTransaction();
			try {

				$log->checkout = date('H:i:s', strtotime($request->punchtime));
				$log->save();

				DB::commit();
				$success = true;

				Session::flash('message', 'Punch is added successfully');
	    		Session::flash('alert-type', 'success');


				return redirect()->route('employeelog');

			} catch(\Exception $e){

                Helper::errormail('HR', 'Add Punch', 'High');
                DB::rollback();
                $success = false;
            }

            if($success == false){
                return redirect('dashboard');
            }


		}

		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeelog.addemployeelog')->with(compact('employee', 'log'));


	}


	public function addemppunch(Request $request){

		$employee = Employee::where('status', 1)->get()->all();
		if($request->isMethod('POST')){

			$request->validate([

				'employeeid' => 'required',
				'punchdate' => 'required|date',
				'checkin' => 'required',
				'checkout' => 'required',

			]);
			$error=0;
			$emppunch = HR_device_emplog::where('dateid',$request->punchdate)->where('empid',$request->employeeid)->get()->first();
			$punch = array();
			$finalpunch = array();
			/*******************/
			if($emppunch){
				array_push($punch,$emppunch->timein1,$emppunch->timeout1,$emppunch->timein2,$emppunch->timeout2,$emppunch->timein3,$emppunch->timeout3,$request->checkin,$request->checkout);
				foreach($punch as $punch1){
					if($punch1 > 0){
						array_push($finalpunch, $punch1);
					}
				}
			
				/*******************/
					sort($finalpunch);
					$punchlength = count($finalpunch);
					
					for($i= 0; $i<$punchlength;$i++){
						if($punchlength == 2){
							if($finalpunch[$i]){
								$emppunch->timein1 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout1 = $finalpunch[$i];
								$i++;
							}
							
						}
						else if($punchlength == 4){
							if($finalpunch[$i]){
								$emppunch->timein1 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout1 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timein2 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout2 = $finalpunch[$i];
								$i++;
							}
						}
						else if($punchlength == 6){
							if($finalpunch[$i]){
								$emppunch->timein1 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout1 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timein2 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout2 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timein3 = $finalpunch[$i];
								$i++;
							}
							if($finalpunch[$i]){
								$emppunch->timeout3 = $finalpunch[$i];
								$i++;
							}
						}
						
					}
			 		$emppunch->save();

				Session::flash('message', 'Punch is added successfully');
				Session::flash('alert-type', 'success');
	
				return redirect()->route('employeelog');
			}else{
				return redirect()->route('employeelog')->withErrors(['Log Not Exists']);
			}
		}

		return view('hr.employeelog.addemployeepunch')->with(compact('employee'));

	}



	//////////////////////////////////////////// Employee Log End   /////////////////////////////////////////////

	//////////////////////////////////////////// salary start //////////////////////////////////////////////////


	public function salary(Request $request){


		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.salary.salary')->with(compact('employee'));

	}

	public function empsalary(Request $request){
		
		$employeeid = Input::get('employeeid');
		$year = Input::get('year');
		$month = Input::get('month');
	
		$if_exist = Salary::where('year', $year)->where('month', $month)->where('employeeid', $employeeid)->first();

		if(!empty($if_exist)){

			$status = $if_exist->status;

			if($status == 'Locked'){

				Session::flash('message', 'Salary is already locked');
	    		Session::flash('alert-type', 'error');

				return redirect()->route('viewlockedsalary');

			}else{

				Session::flash('message', 'Salary is calculated');
	    		Session::flash('alert-type', 'error');

				return redirect()->route('viewsalary');
			}

		}

		$workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
		if(empty($workingdays_data)){

			Session::flash('message', 'Please add workingdays of '.$month);
    		Session::flash('alert-type', 'error');


			return redirect()->route('workingdays')->with(compact('year', 'month'));
		}
		$empdata = Employee::where('employeeid', $employeeid)->first();
		if($empdata->workinghour <= 0){
			return redirect('users')->withErrors('Kindly Add Working Hours');
		}
		if(!empty($employeeid) || !empty($year) || !empty($month)){

		if($request->month == 'Janaury'){
			$cal_month = 1;
		}else if($request->month == 'February'){
			$cal_month = 2;
		}else if($request->month == 'March'){
			$cal_month = 3;
		}else if($request->month == 'April'){
			$cal_month = 4;
		}else if($request->month == 'May'){
			$cal_month = 5;
		}else if($request->month == 'June'){
			$cal_month = 6;
		}else if($request->month == 'July'){
			$cal_month = 7;
		}else if($request->month == 'August'){
			$cal_month = 8;
		}else if($request->month == 'September'){
			$cal_month = 9;
		}else if($request->month == 'October'){
			$cal_month = 10;
		}else if($request->month == 'November'){
			$cal_month = 11;
		}else{
			$cal_month = 12;
		}

		$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
		$fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
		$todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));
		
		
		$searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];

		$employee = Employee::where('status', 1)->get()->all();
		$emptime = Employee::where('employeeid', $employeeid)->first();
		$checkintime = $emptime->workinghourfrom1;
		$checkouttime = $emptime->workinghourto1;

		$employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1', null)->select('hr_device_emplog.dateid', 'hr_device_emplog.timein1', 'hr_device_emplog.timeout1', 'hr_device_emplog.timein2', 'hr_device_emplog.hr_device_emplogid')->groupBy('dateid')->get()->all();
		

		$lateemployeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where(function($query) use ($checkintime, $checkouttime){
			$query->where('timein1', '>', $checkintime)->orWhere('timeout1', '<', $checkouttime);
		})->get()->all();

		$error = 1;
		/*if(!empty($employeelog)){

			Session::flash('message', 'Please complete employee log');
    		Session::flash('alert-type', 'error');

			return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employee', 'error'));

		}*/

	
		//  try {

		$employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1','>',0)->get()->all();
		
		$employeelog_days = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->where('timein1','>',0)->groupBy('dateid')->select('dateid')->get()->all();
		

		$attenddays = count($employeelog_days);
			
		$totalminute = 0;
		$totalhour = 0;
		$totaldays = 0;
		$givenleave = 0;

		foreach($employeelog as $emplog){

			$difference = ROUND(ABS(strtotime($emplog->timeout1) - strtotime($emplog->timein1))/60);
			$totalminute += abs($difference);

		}
		
		$totalhour_dispaly_model = round($totalminute/60);
		
		$totalminute_dispaly = $totalminute;
		/*$hours123 = floor($totalminute / 60);
		$minutes123 = ($totalminute % 60);*/
		//echo $hours123.":".$minutes123;exit;
		

		$noofleave = Leave::where('employeeid', $employeeid)->first();
		if(!empty($noofleave)){
			$givenleave = $noofleave->noofleave;
		}else{
			$givenleave = 0;
		}

		$paidleave = 0;

		$empleave = EmployeeLeave::where('employeeid', $employeeid)->whereBetween('date', [$fromdate, $todate])->get()->all();
		if(!empty($empleave)){
			foreach($empleave as $leaveinfo){
				if($leaveinfo->leavetype == 'Pl'){
					$paidleave += 1;
				}
			}
		}

		$takenleave = count($empleave);
		$takenleave_display = count($empleave);

		$empdata = Employee::where('employeeid', $employeeid)->first();

		/*$employeeaccount = Employeeaccount::where('employeeid', $employeeid)->*/

		$empsalary = $empdata->salary;
		$empworkinghour = $empdata->workinghour;

		$Workindays = 0;
		$holidays = 0;
		$workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
		if(!empty($workingdays_data)){
			$Workindays = $workingdays_data->workingdays;
			$holidays = $workingdays_data->holidays;
		}else{
			$Workindays = 0;
			$holidays = 0;
		}
		/*****for leave cal******/
		$totalworkindays = $Workindays;
		
		$leavedays_cal = $totalworkindays - $attenddays;
	
		/*****End *for leave cal******/
		$actualdays = $Workindays- $workingdays_data->holidays ;
		
		
		//dd($actualdays);

		

		if($leavedays_cal < 0){
			$leavedays_cal = 0;
		}
	
		$empattandedhours=($totalworkindays-$leavedays_cal) * $empworkinghour;
	
		$totalworkinghour = ($Workindays + $holidays) * $empworkinghour;

		$empworkingminute = ($Workindays + $holidays)  * $empworkinghour * 60;
		$totalminute = $attenddays * $empworkinghour * 60; 
		$totalminutedisplay = $totalminute/60;

		$total_hour = ceil($totalminute / 60);
 

		$takenleave = $Workindays - $attenddays;
		
		$totalattenddays = $attenddays + $holidays;
	
		
		$perdaysalary = ($empsalary/($Workindays + $holidays));
		
		$current_salary = number_format((float)($perdaysalary * $totalattenddays), 2, '.', '');

		if($current_salary > $empsalary){
			$current_salary = $empsalary;
		}
		
	
		$store = !empty($request->store) ? $request->store : 0;

		$success = true;
		$nondutyhours=0;
		$nondutyhoursamount=0;

		$emploanamount = EmployeeAccount::where('employeeid', $employeeid)->orderBy('empaccountid', 'desc')->first();

		/*******************if trainer***************************** */
		
		if($empdata->role == 'trainer' || $empdata->role == 'Trainer' ){
			$ptlogs=array();
			$trainerdata=Ptassignlevel::where('trainerid',$empdata->employeeid)->leftjoin('ptlevel','ptassignlevel.levelid','ptlevel.id')->get()->first();
			if($trainerdata){
				$trainerlevel=$trainerdata->level;
				$trainerpercentage=$trainerdata->percentage;
				$trainerschemes=[];
				
				$trainersession=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours','!=',0)->get()->count();
				$nondutyhours=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->get()->count();
				$nondutyhoursamount = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->where('dutyhours',0)->sum('amount');
				
				$trainersessiondetail=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')->whereMonth('actualdate',$cal_month)->whereYear('actualdate',$year)->orderBy('actualdate','desc')->get()->all();
				foreach ($trainersessiondetail as $key => $value) {
					
					$package=MemberPackages::where('memberpackagesid',$value->packageid)
					->leftjoin('schemes','memberpackages.schemeid','schemes.schemeid')
					->get()->first();
					$member=Member::where('memberid',$value->memberid)->get(['member.firstname','member.lastname'])->first();
				
					$value['schemename']=$package->schemename;
					$value['firstname']=$member->firstname;
					$value['lastname']=$member->lastname;
				

				}
				$ptlogs = Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')
				->whereMonth('actualdate',$cal_month)
				->whereYear('actualdate',$year)
				->groupBy('memberid')
				->orderBy('actualdate','desc')->get()->all();
				foreach($ptlogs as $ptlog){
					$ptlogcount = 	$trainersessioncount=Claimptsession::where('trainerid',$empdata->employeeid)->where('status','Active')
							->whereMonth('actualdate',$cal_month)
							->whereYear('actualdate',$year)
							->orderBy('actualdate','desc')
							->where('memberid',$ptlog->memberid)->get()->count();
					$member=Member::where('memberid',$ptlog->memberid)->get(['member.firstname','member.lastname'])->first();
					$ptlog['schemename']=$package->schemename;
					$ptlog['firstname']=$member->firstname;
					$ptlog['lastname']=$member->lastname;
					$ptlog['count']=$ptlogcount;
				}
				
				$trainerdetail=[];
				$trainerdetail['trainerlevel']=$trainerlevel;
				$trainerdetail['trainerpercentage']=$trainerpercentage;
				$trainerdetail['trainershemes']=$trainersessiondetail;
			
				$perhoursalary = $perdaysalary / $empworkinghour;
				$totalsessionprice=0;
				
				$current_salary = $current_salary - ($perhoursalary*$trainersession);
			
				foreach($trainerdetail['trainershemes'] as $schemedetail)  
				{
					$totalsessionprice += $schemedetail->amount;
				}
				$current_salary = $current_salary + $totalsessionprice;
				$current_salary = round($current_salary ,  2);
				$allsessionprice = $totalsessionprice;
				
			}else{
				Session::flash('message', 'Please assign level to trainer ');
    			Session::flash('alert-type', 'error');
				return redirect()->route('assignptlevel');
			}
			
		}else{
			$trainerdetail =[];
			$trainersession =0;
			$allsessionprice=0;
			$trainersessiondetail=[];
			$ptlogs = array();
		}
	
		/*******************for trainer session wise salary***************************** */


		/*********************for trainer session wise salary*************************** */

		/*******************end if trainer***************************** */
	
		return view('hr.salary.calculatesalary')->with(compact('attenddays', 'totalminute', 'totalhour', 'totaldays', 'givenleave', 'takenleave', 'empdata', 'empsalary','empattandedhours', 'empworkinghour', 'total_hour', 'year', 'month','cal_month', 'Workindays', 'holidays', 'empworkingminute', 'current_salary', 'employeeid', 'takenleave_display', 'Workindays', 'leavedays_cal', 'totalworkinghour', 'employeelog', 'totalminute_dispaly', 'totalhour_dispaly_model', 'emploanamount', 'lateemployeelog', 'actualdays','trainersession','trainersessiondetail','trainerdetail','nondutyhours','nondutyhoursamount','allsessionprice','ptlogs'));

	// }  catch(\Exception $e) {

	// 	Helper::errormail('Hr', 'Calculate Salary', 'High');

	// 	$success = false;
	// }

	// if($success == false){
	// 	return redirect('dashboard');
	// }




	}
}

	public function storeempsalary(Request $request){
	
		/*$request->validate([

			'attenddays_display' => 'required|numeric|digits_between:1,2',
			'takenleave_display' => 'required|numeric|digits_between:1,2',
			'casualleave' => 'nullable|numeric|digits_between:1,2',
			'medicalleave' => 'nullable|numeric|digits_between:1,2',
			'paidleave' => 'nullable|numeric|digits_between:1,2',
			'current_salary' => 'required|numeric|digits_between:1,10',

		]);*/

		$if_exist = Salary::where('year', $request->year)->where('month', $request->month)->where('employeeid', $request->employeeid)->first();

		if(!empty($if_exist)){

			Session::flash('message', 'Employee Salary is already locked');
			Session::flash('alert-type', 'error');

			return redirect()->route('viewlockedsalary');
		}

		DB::beginTransaction();
		try {
			
			if($request->emi > 0){

				$empaccount = EmployeeAccount::where('employeeid', $request->employeeid)->orderBy('empaccountid', 'desc')->first();
				
				if(!empty($empaccount)){

					$empamount = $empaccount->amount;
					if($empamount > 0 || $empamount >= $request->emi){
						$finalamount = $empamount - $request->emi;

						$newempaccount = new EmployeeAccount();
						$newempaccount->employeeid = $request->employeeid;
						$newempaccount->amount = $finalamount;
						$newempaccount->type = 'EMI';
						$newempaccount->empaccountdate = date('Y-m-d');
						$newempaccount->actionby = session()->get('admin_id');
						$newempaccount->save();

					}

				}

			}
			$tsessionsalary=[];
			$tsessionsalarystring='';
			if($tsessionsalary > 0){

				$trainersession=Claimptsession::where('trainerid',$request->employeeid)->where('status','Active')->whereMonth('actualdate', $request->cal_month)->whereYear('actualdate',$request->year)->get()->count();
				$trainersessiondetail=Claimptsession::where('trainerid',$request->employeeid)->where('status','Active')->whereMonth('actualdate', $request->cal_month)->whereYear('actualdate',$request->year)->orderBy('actualdate','asc')->get()->all();
				
				foreach($trainersessiondetail as $tsession){
					$tsession->status = "Paid";
					$tsession->save();
					$sessionpt=Ptmember::where('date',$tsession->scheduledate)->where('hoursfrom',$tsession->scheduletime)->get()->first();
				
					$sessionpt->status = "Paid";
					$sessionpt->save();
					array_push($tsessionsalary,$tsession->claimptsessionid);
				}
			}
			if(count($tsessionsalary) > 0){
				$tsessionsalarystring = implode (",", $tsessionsalary);
			}
			
			
			$salary = new Salary();
			$salary->remark = $request->remark;
			$salary->employeeid = $request->employeeid;
			$salary->workingdays = $request->Workindays;
			$salary->attenddays = $request->attenddays_display;
			$salary->actualdays = $request->actualdays_display;
			$salary->totalminute = $request->workingminute;
			$salary->empworkingminute = $request->empworkingminute;
			$salary->empworkinghour = $request->monthlyworking_hour_display;
			$salary->totalhour = $request->totalworkinghour_display;
			$salary->givenleave = $request->givenleave;
			$salary->takenleave = $request->takenleave_display;
			$salary->empsalary = $request->empsalary;
			$salary->currentsalary = $request->current_salary;
			$salary->holidays = $request->holidays;
			$salary->casualleave = !empty($request->casualleave) ? $request->casualleave : 0;
			$salary->medicalleave = !empty($request->medicalleave) ? $request->medicalleave : 0;
			$salary->paidleave = !empty($request->paidleave) ? $request->paidleave : 0;
			$salary->year = $request->year;
			$salary->month = $request->month_display;
			$salary->ptsessionid = $tsessionsalarystring;
			$salary->ptsessionsalary = $request->totalsessionprice;
			$salary->salaryemi = !empty($request->emi) ? $request->emi : 0;
			$salary->salaryothercharges = !empty($request->otheramount) ? $request->otheramount : 0;
			$salary->loanamount = !empty($request->loan) ? $request->loan : 0;
			$salary->status = 'Unlocked';
			$salary->actionby = session()->get('admin_id');

			$salary->save();

			DB::commit();
			$success = true;
			
			Session::flash('message', 'Employee Salary is locked');
			Session::flash('alert-type', 'success');

			return redirect()->route('viewsalary');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Store Salary', 'High');

			DB::rollback();
			$success = false;
		}

		if($success == false){
			return redirect('dashboard');
		}

	}

	public function viewlockedsalary(Request $request){

		$salary = Salary::with('employee')->where('status', 'Locked')->paginate(10);
		$employee  = Employee::where('status', 1)->get()->all();

		return view('hr.salary.viewlockedsalary')->with(compact('salary', 'employee'));

	}


	public function viewsalary(){

		$salary = Salary::with('employee')->where('status', 'Unlocked')->paginate(10);

		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.salary.viewsalary')->with(compact('salary', 'employee'));

	}

	public function editsalary($id, Request $request){
		
		$salary = Salary::with('employee')->where('salaryid', $id)->first();
		$allsession='';
		$dutyhours=array();
		$nondutyhours=array();
		$dutyhourssalary=0;
$nondutyhourssalary=0;
		if(!empty($salary->ptsessionid)){
			$ptsessionarray = explode (",", $salary->ptsessionid);  
			$allsession=Claimptsession::whereIn('claimptsessionid',$ptsessionarray)->get()->all();
		}
		if($allsession){
			foreach ($allsession as $key => $value) {
				if($value->dutyhours == 1){
					$dutyhours[]=$value;
					$dutyhourssalary+=$value->amount;
				}else{
					$nondutyhours[]=$value;
					$nondutyhourssalary+=$value->amount;
				}
			}
		}
		
		$employeeid = $salary->employeeid;
		$month = $salary->month;
		$year = $salary->year;

		if($month == 'Janaury'){
			$cal_month = 1;
		}else if($month == 'February'){
			$cal_month = 2;
		}else if($month == 'March'){
			$cal_month = 3;
		}else if($month == 'April'){
			$cal_month = 4;
		}else if($month == 'May'){
			$cal_month = 5;
		}else if($month == 'June'){
			$cal_month = 6;
		}else if($month == 'July'){
			$cal_month = 7;
		}else if($month == 'August'){
			$cal_month = 8;
		}else if($month == 'September'){
			$cal_month = 9;
		}else if($month == 'October'){
			$cal_month = 10;
		}else if($month == 'November'){
			$cal_month = 11;
		}else{
			$cal_month = 12;
		}

		$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
		$fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
		$todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));
		
		$employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->get()->all();
		$emploanamount = EmployeeAccount::where('employeeid', $employeeid)->orderBy('empaccountid', 'desc')->pluck('amount')->first();

		if($request->isMethod('POST')){
	
			$request->validate([

				'attenddays_display' => 'required|numeric',
				'takenleave_display' => 'required|numeric',
				'casualleave' => 'nullable|numeric',
				'medicalleave' => 'nullable|numeric',
				'paidleave' => 'nullable|numeric',
				'current_salary' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',

			]);

			DB::beginTransaction();
			try {

			$salary->employeeid = $request->employeeid;
			$salary->workingdays = $request->workingdays_display;
			$salary->attenddays = $request->attenddays_display;
			$salary->actualdays = $request->actualdays_display;
			$salary->totalminute = $request->workingminute;
			$salary->empworkingminute = $request->empworkingminute;
			$salary->empworkinghour = $request->monthlyworking_hour_display;
			$salary->totalhour = $request->totalworkinghour_display;
			$salary->givenleave = $request->givenleave;
			$salary->takenleave = $request->takenleave_display;
			$salary->empsalary = $request->empsalary;
			$salary->currentsalary = $request->current_salary;
			$salary->holidays = $request->holidays;
			$salary->casualleave = !empty($request->casualleave) ? $request->casualleave : 0;
			$salary->medicalleave = !empty($request->medicalleave) ? $request->medicalleave : 0;
			$salary->paidleave = !empty($request->paidleave) ? $request->paidleave : 0;
			$salary->year = $request->year;
			$salary->month = $request->month_display;
			$salary->salaryemi = $request->emi;
			$salary->salaryothercharges = $request->otheramount;
			$salary->loanamount = $request->loan;
					$salary->remark = $request->remark;
			$salary->status = 'Unlocked';
			$salary->actionby = session()->get('admin_id');

			$salary->save();

			DB::commit();
			$success = true;

			Session::flash('message', 'Employee Salary is updated');
			Session::flash('alert-type', 'success');

			return redirect()->route('viewsalary');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Edit Salary', 'High');

			DB::rollback();
			$success = false;
		}

		if($success == false){
			return redirect('dashboard');
		}


		}


		return view('hr.salary.editsalary')->with(compact('salary', 'employeelog','emploanamount','allsession','dutyhours','nondutyhours','dutyhourssalary','nondutyhourssalary'));

	}

	public function locksalary($id){

		$salary = Salary::findOrfail($id);

		DB::beginTransaction();
		try {

			$salary->status = 'Locked';
			$salary->save();

			DB::commit();
			$success = true;

			Session::flash('message', 'Employee Salary is locked');
			Session::flash('alert-type', 'success');

			return redirect()->route('viewlockedsalary');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Lock Salary', 'High');

			DB::rollback();
			$success = false;
		}

		if($success == false){

			return redirect('dashboard');
		}

	}

	public function unlocksalary($id){

		$salary = Salary::findOrfail($id);

		DB::beginTransaction();
		try {
			$salary->status = 'Unlocked';
			$salary->save();
			DB::commit();
			$success = true;
			Session::flash('message', 'Employee Salary is Unlocked');
			Session::flash('alert-type', 'success');
			
			return redirect()->route('viewsalary');

		} catch(\Exception $e) {

			Helper::errormail('HR', 'Unlock Salary', 'High');

			DB::rollback();
			$success = false;
		}

		if($success == false){

			return redirect('dashboard');
		}

	}

	public function confirmsalary(Request $request){

		$accountno = $request->accountno;
		$empname = $request->empname;
		$empid = $request->empid;
		$salaryid = $request->salaryid;

		$salary = Salary::findOrfail($salaryid);
		$salary->accountno = $accountno;
		$salary->ispaid = 1;
		$emi = $salary->salaryemi;
		$employeeid = $salary->employeeid;
		$salary->paymenttype = $request->paymenttype;
				$salary->remark2 = $request->remark2;

		$salary->paidby = session()->get('admin_id');
		$salary->paiddate = date('Y-m-d');
		$salary->save();

		if($emi > 0){

				$empaccount = EmployeeAccount::where('employeeid', $employeeid)->orderBy('empaccountid', 'desc')->first();
				
				if(!empty($empaccount)){

					$empamount = $empaccount->amount;
					if($empamount > 0 || $empamount >= $emi){
						$finalamount = $empamount - $emi;

						$newempaccount = new EmployeeAccount();
						$newempaccount->employeeid = $employeeid;
						$newempaccount->amount = $finalamount;
						$newempaccount->type = 'EMI';
						$newempaccount->empaccountdate = date('Y-m-d');
						$newempaccount->actionby = session()->get('admin_id');
						$newempaccount->save();

					}

				}

			}

		return 201;
	}

	public function viewlockedsalarysearch(Request $request){

		$employeeid = $request->employeeid;
		$month = $request->month;
		$year = $request->year;
		
		$salary = Salary::where('employeeid', $employeeid)->where('month', $month)->where('year', $year)->paginate(10);
		$employee  = Employee::where('status', 1)->get()->all();

		return view('hr.salary.viewlockedsalary')->with(compact('salary', 'employee', 'employeeid', 'month', 'year'));

	}

	public function searchsalary(Request $request){

		$employeeid = Input::get('employeeid');
		$year = Input::get('year');
		$month = Input::get('month');

		$salary = Salary::where('employeeid', $employeeid)->where('month', $month)->where('year', $year)->paginate(10);
		$employee  = Employee::where('status', 1)->get()->all();
		/*dd($salary->month);*/

		return view('hr.salary.viewsalary')->with(compact('salary', 'employee', 'employeeid', 'year', 'month'));


	}

	//////////////////////////////////////////// salary end   //////////////////////////////////////////////////




///////////////////////////////////// Employee Leave start //////////////////////////////////////////////////////////////

	public function employeeleave(Request $request){



		if($request->isMethod('post')){

			$request->validate([

				'employeeid' =>  'required',
				'leavedate' =>  'required',
				'reason' =>  'nullable|max:255',

			]);


			$employeeid = $request->employeeid;
			$leavecount = 0;
			$totalleave = 0;

			$empleave = Leave::where('employeeid', $employeeid)->first();
			if(empty($empleave)){
				$employee = $request->employeeid;
				$employee  = Employee::where('status', 1)->get()->all();

				Session::flash('message', 'Please add employee leave');
				Session::flash('alert-type', 'error');

				return redirect()->route('leave')->with(compact('employee'));
			}else{

				$totalleave = $empleave->noofleave;
			}

			
			$leavecount  = EmployeeLeave::where('employeeid', $employeeid)->get()->all();
			$leavecount = count($leavecount);
			

			if($leavecount > $totalleave){
				return back()->with('error', 'You can not add leave as Employee leaves are already used!');
			}

			$existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->first();
			if(!empty($existleave)){
				return back()->withInput()->with('error', 'You can not add same leave!');

			}

			DB::beginTransaction();
			try {

				$employeeleave = new EmployeeLeave();
				$employeeleave->employeeid =  $employeeid;
				$employeeleave->date =  date('Y-m-d', strtotime($request->leavedate));
				$employeeleave->leavetype = $request->leavetype;
				$employeeleave->reason =  !empty($request->reason) ? $request->reason : null;
				$employeeleave->actionby = session()->get('admin_id');
				$employeeleave->Save();
				
				DB::commit();
				$success = true;

				Session::flash('message', 'Employee leave is added successfully');
				Session::flash('alert-type', 'success');

				return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is added successfully.');

			} catch(\Exception $e) {

				Helper::errormail('HR', 'Add Employee Leave', 'High');

				DB::rollback();
				$success = false;
			}

			if($success == false){
				return redirect('dashboard');
			}



		}


		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeeleave.addemployeeleave')->with(compact('employee'));



	}

	public function editemployeeleave($id, Request $request){

		$empleave = EmployeeLeave::where('employeeleaveid', $id)->first();

		$empexpirydate = Leave::where('employeeid', $empleave->employeeid)->first();
		
		if(!empty($empexpirydate)){

			$expirydate = $empexpirydate->expirydate;

		}else{

			$expirydate='';
		}

		if($request->isMethod('post')){

			$request->validate([

				'leavedate' =>  'required',
				'reason' =>  'nullable|max:255',

			]);

			$employeeid = $empleave->employeeid;
			
			$existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->where('employeeleaveid', '!=', $id)->first();
			if(!empty($existleave)){
				return back()->with('error', 'You can not add same leave!');

			}

			DB::beginTransaction();
			try {

				$empleave->date =  date('Y-m-d', strtotime($request->leavedate));
				$empleave->reason =  !empty($request->reason) ? $request->reason : null;
				$empleave->leavetype = $request->leavetype;
				$empleave->actionby = session()->get('admin_id');
				$empleave->Save();

				DB::commit();
				$success = true;

				Session::flash('message', 'Employee leave is updated successfully');
				Session::flash('alert-type', 'success');

				return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is updated successfully');

			} catch(\Exception $e) {

				Helper::errormail('HR', 'Edit Employee Leave', 'High');

				DB::rollback();
				$success = false;
			}

			if($success == false){
				return redirect('dashboard');
			}


			
		}


		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeeleave.editemployeeleave')->with(compact('empleave', 'employee', 'expirydate'));






	}

	public function viewemployeeleave(){

		$employeeleave = EmployeeLeave::with('empname')->paginate(10);
		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee'));


	}

	public function searchemployeeleave(Request $request){

		$employeeid = $request->employeeid;

		$employeeleave = EmployeeLeave::where('employeeid', $employeeid)->get()->all();
		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee', 'employeeid'));

	}

	public function empexpirydate(){

		$empid = $_REQUEST['empid'];

		$empexpirydate = Leave::where('employeeid', $empid)->first();
		//dd($empexpirydate);

		if(!empty($empexpirydate)){

			$expirydate = $empexpirydate->expirydate;

			return $expirydate;

		}else{

			return 'leavenotfound';

		}



	}



	public function deleteemployeeleave($id){

		DB::beginTransaction();
		try {

		$empexpirydate = EmployeeLeave::where('employeeleaveid', $id)->first();
		if($empexpirydate){
			$empexpirydate->delete();
		}
		

		DB::commit();
		$success = true;

		return redirect()->route('viewemployeeleave')->with('error', 'Employee leave is deleted');

	} catch(\Exception $e) {

		Helper::errormail('HR', 'Delete Employee Leave', 'High');

		DB::rollback();
		$success = false;
	}

	if($success == false){
		return redirect('dashboard');
	}


	}

	public function employeelogdaywise(Request $request){

		$employee = Employee::where('status', 1)->get()->all();

		return view('hr.employeelog.viewemployeelogdaywise')->with(compact('employee'));

	}

	public function searchemployeelogdaywise(Request $request){

		if ($request->ajax()) {

		$employeeid = $request->employeeid;
		$year = $request->year;
		$month = $request->month;

		if(!empty($employeeid) || !empty($year) || !empty($month)){

		if($request->month == 'Janaury'){
			$cal_month = 1;
		}else if($request->month == 'February'){
			$cal_month = 2;
		}else if($request->month == 'March'){
			$cal_month = 3;
		}else if($request->month == 'April'){
			$cal_month = 4;
		}else if($request->month == 'May'){
			$cal_month = 5;
		}else if($request->month == 'June'){
			$cal_month = 6;
		}else if($request->month == 'July'){
			$cal_month = 7;
		}else if($request->month == 'August'){
			$cal_month = 8;
		}else if($request->month == 'September'){
			$cal_month = 9;
		}else if($request->month == 'October'){
			$cal_month = 10;
		}else if($request->month == 'November'){
			$cal_month = 11;
		}else{
			$cal_month = 12;
		}

		$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
		$fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
		$todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));
		
		$searchparameter = ['employeeid' => $employeeid, 'month' => $month, 'year' => $year];

		$employeelog = HR_device_emplog::where('empid', $employeeid)->whereBetween('dateid', [$fromdate, $todate])->groupBy('dateid')->get();

		return datatables()->of($employeelog)
		->editColumn('timeout1', function($employeelog){
			if(!empty($employeelog->timeout1)){
				return $employeelog->timeout1;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})->editColumn('timein2', function($employeelog){
			if(!empty($employeelog->timein2)){
				return $employeelog->timein2;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})->editColumn('timeout2', function($employeelog){
			if(!empty($employeelog->timeout2)){
				return $employeelog->timeout2;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})->editColumn('timein3', function($employeelog){
			if(!empty($employeelog->timein3)){
				return $employeelog->timein3;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})
		->editColumn('timeout3', function($employeelog){
			if(!empty($employeelog->timeout3)){
				return $employeelog->timeout3;
			}else{
				if(session()->get('logged_role') == 'Admin'){

					//return "<a href=".route('addpunch', $employeelog->emplogid)." class='btn btn-danger'>Miss</a>";
				}else{
					//return "<a class='btn btn-danger' disabled title='Dare to edit this'>Miss</a>";
				}
			}

		})
		->escapeColumns([])
		->make(true);

		//$employee = Employee::where('status', 1)->get()->all();


		//$employeelog->appends(array('employeeid' => $employeeid, 'year' => $year, 'month' => $month));

		
		//return view('hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employeelog', 'employee', 'searchparameter'));

		}
	}
	}






///////////////////////////////////// Employee Leave End ////////////////////////////////////////////////////////////////


////////////////////////////////////////// import punch /////////////////////////////////////////////////////////////
public function importpunch(Request $request){


	$employee = Employee::where('status', 1)->get()->all();
	
	return view('hr.employeelog.importpunch')->with(compact('employee'));

}


public function downloaddemosheet(Request $request){
	

	if($request->isMethod('POST')){


		$employeeid = $request->employeeid;
		$month = $request->month;
		$year = $request->year;
		
		ExcelExport::truncate();
		/*$excel = ExcelExport::all();
		if(!empty($excel)){
			foreach($excel as $e){
				ExcelExport::where('excelexportid', $e->excelexportid)->delete();
			}
		}*/
		
		$fullname = '';

		if($employeeid && $month && $year){

			$empdetail = Employee::where('employeeid', $employeeid)->first();
			if(!empty($empdetail)){

				$fullname = ucfirst($empdetail->first_name).' '.ucfirst($empdetail->last_name);
			}

			if($request->month == 'Janaury'){
				$cal_month = 1;
			}else if($request->month == 'February'){
				$cal_month = 2;
			}else if($request->month == 'March'){
				$cal_month = 3;
			}else if($request->month == 'April'){
				$cal_month = 4;
			}else if($request->month == 'May'){
				$cal_month = 5;
			}else if($request->month == 'June'){
				$cal_month = 6;
			}else if($request->month == 'July'){
				$cal_month = 7;
			}else if($request->month == 'August'){
				$cal_month = 8;
			}else if($request->month == 'September'){
				$cal_month = 9;
			}else if($request->month == 'October'){
				$cal_month = 10;
			}else if($request->month == 'November'){
				$cal_month = 11;
			}else{
				$cal_month = 12;
			}

			$day_in_month = cal_days_in_month(CAL_GREGORIAN,$cal_month,$year);
			$fromdate = date('Y-m-d',strtotime("$year-$cal_month-01"));
			$todate = date('Y-m-d',strtotime("$year-$cal_month-$day_in_month"));

			$export_array = [];

			for($i = 1; $i<= $day_in_month; $i++){

				$current_date = date('Y-m-d',strtotime("$year-$cal_month-$i"));
			
				$excel = new ExcelExport();
							 							
				$current_date;
				$excel->dateid = $current_date;
				$excel->empid = $employeeid;
				$excel->timein1 = '';
				$excel->timeout1 = '';
				$excel->timein2 = '';
				$excel->timeout2 = '';
				$excel->timein3 = '';
				$excel->timeout3 = '';
				$excel->type = '';
				$excel->leave = '';
				$excel->totalworkinghours = '';
				$excel->salary = '';
				$excel->save();

			}
			
		$isexport = 1;
		$employee = Employee::where('status', 1)->get()->all();
		$employee_name = $fullname.'-'.$request->month.'-'.$request->year.'.csv';

		Session::flash('downloadexcel', 'downloadexcel');
		Session::put('empname', $employee_name);

		Session::flash('message', 'Employee sheet will download shortly');
		Session::flash('alert-type', 'success');

		//return Excel::download(new EmployeeExport(),'user.csv');

		//return view('hr.employeelog.importpunch')->with(compact('employee', 'employeeid', 'month', 'year', 'isexport'));

		return redirect()->route('importpunch');

		}
	}

}

public function downloadexcel(){

	$empname = session()->get('empname');
	$grid=ExcelExport::get()->all();
	$employeename='';

	if($grid){
	
		$student_array[] = array('dateid','Employeeid','timein1','timeout1','timein2','timeout2','timein3','timeout3','type','leave','totalworkinghours','salary');
 
	 foreach ($grid as $student)
	 {
	   
		 $student_array[] = array(
			 'dateid' =>$student->dateid,
			 'empid' =>$student->empid,
			 'timein1' => $student->timein1,
			 'timeout1' => $student->timeout1,
			 'timein2' => $student->timein2,
			 'timeout2' =>$student->timeout2,
			 'timein3' =>$student->timein3,
			 'timeout3'=>$student->timeout3,
			 'type'=>$student->type,
			 'leave'=>$student->leave,
			 'totalworkinghours' => $student->totalworkinghours,
			 'salary'=>$student->salary,

		 );
		 
	 }
	
	 Excel::create($empname, function($excel) use ($student_array) {
					 $excel->sheet('mySheet', function($sheet) use ($student_array)
					 {
 
						$sheet->fromArray($student_array);
 
					 });
				})->export('csv');
				
			}		

}



public function importemppunchcsv(Request $request){

	$request->validate([

		'file' => 'required'

	]);

	$file = $request->file('file');

	 // File Details 
	$filename = $file->getClientOriginalName();
	$extension = $file->getClientOriginalExtension();
	$path = $file->getRealPath();
	$fileSize = $file->getSize();
	$mimeType = $file->getMimeType();

	$valid_extension = array("csv");

	$maxFileSize = 2097152; 

	// Check file extension
	  if(in_array(strtolower($extension),$valid_extension)){

		  // Check file size
		  if($fileSize <= $maxFileSize){

			  $data = array_map('str_getcsv', file($path));
				
			  foreach($data as $key => $csv_data){
				  if($key > 1){
					$dateid= $csv_data[0];
					  $empid = $csv_data[1];
					  $empdate = $csv_data[0];
					  $timein1 = $csv_data[2];
					  $timeout1 = $csv_data[3];
					  $timein2 = $csv_data[4];
					  $timeout2 = $csv_data[5];
					  $timein3 = $csv_data[6];
					  $timeout3 = $csv_data[7];
				

					  if(!empty($empid) && is_numeric($empid) && !empty($empdate) && strtotime($empdate) && !empty($timein1) &&  !empty($timeout1)){

						  $employeelog_exist = HR_device_emplog::where('empid', $empid)->where('dateid', date('Y-m-d', strtotime($empdate)))->first();

						  if(empty($employeelog_exist)){

							  $employeelog = new HR_device_emplog();
							  $employeelog->dateid = date('Y-m-d', strtotime($empdate));
							  $employeelog->empid = $empid;
							  $employeelog->timein1 = $csv_data[2];
							  $employeelog->timeout1 =$csv_data[3];
							  $employeelog->timein2 = $csv_data[4];
							  $employeelog->timeout2 =$csv_data[5];
							  $employeelog->timein3= $csv_data[6];
							  $employeelog->timeout3 =$csv_data[7];
							  $employeelog->save();

						  }else{
							$employeelog_exist->delete();
									
							$employeelog = new HR_device_emplog();
							$employeelog->dateid = date('Y-m-d', strtotime($empdate));
							$employeelog->empid = $empid;
							$employeelog->timein1 = $csv_data[2];
							$employeelog->timeout1 =$csv_data[3];
							$employeelog->timein2 = $csv_data[4];
							$employeelog->timeout2 =$csv_data[5];
							$employeelog->timein3= $csv_data[6];
							$employeelog->timeout3 =$csv_data[7];
							$employeelog->save();
							
						  }
					  }
					  /**********************for calculate working hours*******************************/
					//   $sumdiff =0;
					//   $total=0;
					  
					// 		for ($i=1;$i<=3;$i++){
					// 			// if($employeelog->totalworkinghours > 0){
					// 			// 	$sumdiff =	$employeelog->totalworkinghours;
								
					// 			// }
							
					// 			$ts1 = Carbon::parse($employeelog['timein'.$i]);
							
					// 			$ts2 = Carbon::parse($employeelog['timeout'.$i]);
					// 			$diff=$ts2->diff($ts1)->format('%H:%I:%S');
					// 			// $difference = round(abs($ts2 - $ts1) / 3600,2);
					// 			if($diff > 0){
					// 				$sumdiff =  strtotime($employeelog->totalworkinghours) + strtotime($diff);
								
								
					// 				$sumdiff = strtotime($employeelog->totalworkinghours) + strtotime($total);
					// 				$total =   date('h:i:s',$sumdiff);
					// 			}
								
					// 			}
					
					// 	   $employeelog->totalworkinghours = 	$total ;
					// 	   $employeelog->save();
						
						  /*********************End for calculate working hours***************************/
						
				  }
			  }

			  Session::flash('message', 'Employee punch is added successfully');
			  Session::flash('alert-type', 'success');

			  return redirect()->back();

		  }

	  }

	}
	////////////////////////////////////////// import punch end/////////////////////////////////////////////////////////////
	
	/*****************************Salary Slip************************************** */
	public function printsalaryslip($id){
		
		$salary=Salary::where('salaryid',$id)->get()->first();
		$employee=Employee::where('employeeid',$salary->employeeid)->get()->first();
		$employeefullname=ucfirst($employee->first_name).' '.ucfirst($employee->last_name);
        $pdf = PDF::loadView('hr.salary.salaryslip', compact('salary','employeefullname'));
  
        return $pdf->stream('Salary Slip.pdf');
	}
	/******************************************************************* */
	public function getpunchrecord(Request $request){
		$punchdate=$request->punchdate;
		$empid = $request->empid;
		$result=HR_device_emplog::where('empid',$empid)->where('dateid',$punchdate)->get()->first();
		return $result;
	}
	

}

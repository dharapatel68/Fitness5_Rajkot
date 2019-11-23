<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkingDays;
use App\Leave;
use App\EmployeeAccount;
use App\Employee;
use App\User_log;
use App\EmployeeLog;
use App\Salary;
use App\EmployeeLeave;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use DB;

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

			$holiday_cal = $day_in_month - $workingdays; 

			$workingdays_obj = new WorkingDays();
			$workingdays_obj->year = $year;
			$workingdays_obj->month = $request->month;
			$workingdays_obj->holidays = $holiday_cal;
			$workingdays_obj->workingdays = $workingdays;
			$workingdays_obj->save();

			DB::commit();
			$success = true;

			return redirect()->route('viewworkingdays')->with('success', 'Working days is added successfully');

		 } catch (\Exception $e) {
        
          $success = false;
          DB::rollback();

        }
        
        if ($success == false) { 
          return redirect('dashboard');
        }


		}


		return view('admin.hr.workingdays.addworkingdays');

	}

	public function viewworkingdays(){

		$working_days = WorkingDays::all();

		return view('admin.hr.workingdays.viewworkingdays', compact('working_days'));



	}

	public function editworkingdays($id, Request $request){

		$working_days = WorkingDays::findOrfail($id);

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

			$holiday_cal = $day_in_month - $workingdays; 

			$workingdays_obj = WorkingDays::findOrfail($id);
			$workingdays_obj->year = $year;
			$workingdays_obj->month = $request->month;
			$workingdays_obj->holidays = $holiday_cal;
			$workingdays_obj->workingdays = $workingdays;
			$workingdays_obj->save();

			DB::commit();
			$success = true;

			return redirect()->route('viewworkingdays')->with('success', 'Working days is added successfully');

		} catch(\Exception $e) {

			DB::rollback();
			$success = false;

		}

		if ($success == false) { 
          return redirect('dashboard');
        }


		}

		return view('admin.hr.workingdays.editworkingdays', compact('working_days'));



	}

	public function searchyear(Request $request){

		$year = $request->year;

		$working_days = WorkingDays::where('year', $year)->orderBy('workingcalid', 'asc')->get()->all();

		return view('admin.hr.workingdays.viewworkingdays', compact('working_days', 'year'));
	}

	/////////////////////////////////////////// Working Days End   ////////////////////////////////////////////////////////



	/////////////////////////////////////////// Leave Start   ////////////////////////////////////////////////////////


	public function leave(Request $request){


		if($request->isMethod('post')){


			$request->validate([

				'employeeid' => 'required|unique:leave,employeeid',
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

			return redirect()->route('viewleave')->with('success', 'Leave is added successfully');
		} catch(\Exception $e) {

			Db::rollback();
			$success = false;

		}

		if($success == false){
			return redirect('dashboard');
		}


		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('admin.hr.leave.addleave', compact('employee'));

	}

	public function viewleave(){

		$Leave = Leave::with('employeename')->get()->all();
		//dd($Leave);
		return view('admin.hr.leave.viewleave', compact('Leave'));

	}

	public function editleave($id, Request $request){

		$Leave_obj = Leave::findOrfail($id);


		if($request->isMethod('post')){


			$request->validate([

				'employeeid' => ['required', Rule::unique('leave')->ignore($id, 'leaveid')],
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

			return redirect()->route('viewleave')->with('success', 'Leave is edited successfully');
		} catch(\Exception $e){

			DB::rollback();
			$success = false;

		}

		if($success == false){
			return redirect('dashboard');
		}

		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('admin.hr.leave.editleave', compact('Leave_obj', 'employee'));

	}

	public function searchleaveyear(Request $request){

		$year = $request->year;

		$Leave = Leave::where('leaveyear', $year)->orderBy('leaveid', 'asc')->get()->all();

		return view('admin.hr.leave.viewleave', compact('Leave', 'year'));
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
			$employeeaccount = new EmployeeAccount();
			$employeeaccount->employeeid = $request->employeeid;
			$employeeaccount->amount = $request->amount;
			$employeeaccount->type = $request->type;
			$employeeaccount->empaccountdate = date('Y-m-d h:i:s');
			$employeeaccount->actionby = session()->get('admin_id');
			$employeeaccount->save();

			Db::commit();
			$success = true;

			return redirect()->route('viewemployeeaccount')->with('success', 'Amount is added successfully');

		} catch(\Exception $e) {

		  $success = false;
          DB::rollback();

		}

		if ($success == false) { 
          return redirect('dashboard');
        }

		}

		$employee = Employee::where('status', 1)->get()->all();
		return view('admin.hr.account.addemployeeamount', compact('employee'));


	}

	public function viewemployeeaccount(){

		$account = EmployeeAccount::with('employeename')->get()->all();
		$employee = Employee::where('status', 1)->get()->all();


		return view('admin.hr.account.viewemployeeamount')->with(compact('account', 'employee'));


	}

	public function searchemployeeaccount(Request $request){

		$empid = $request->employeeid;

		$account = EmployeeAccount::with('employeename')->where('employeeid', $empid)->get()->all();
		$employee = Employee::where('status', 1)->get()->all();


		return view('admin.hr.account.viewemployeeamount')->with(compact('account', 'employee', 'empid '));


	}





	//////////////////////////////////////////// Employee Acoount End   /////////////////////////////////////////////


	//////////////////////////////////////////// Employee Log Start //////////////////////////////////////////////

	public function employeelog(){

		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeelog.viewemployeelog')->with(compact('employee'));

	}

	public function searchemployeelog(Request $request){

		$employeeid = Input::get('employeeid');
		$year = Input::get('year');
		$month = Input::get('month');

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

		$employeelog = EmployeeLog::where('userid', $employeeid)->whereBetween('punchdate', [$fromdate, $todate])->orderBy('checkout', 'asc')->paginate(10);

		$employee = Employee::where('status', 1)->get()->all();


		$employeelog->appends(array('employeeid' => $employeeid, 'year' => $year, 'month' => $month));

		
		return view('admin.hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employeelog', 'employee', 'searchparameter'));

		}

		return redirect()->route('employeelog');


	}


	public function addpunch($id, Request $request){

		$log = EmployeeLog::findOrfail($id);

		if($request->isMethod('post')){

			$request->validate([

				'punchtime' => 'required',


			]);

			$log->checkout = date('H:i:s', strtotime($request->punchtime));
			$log->save();

			return redirect()->route('employeelog');


		}

		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeelog.addemployeelog')->with(compact('employee', 'log'));


	}


	//////////////////////////////////////////// Employee Log End   /////////////////////////////////////////////

	//////////////////////////////////////////// salary start //////////////////////////////////////////////////


	public function salary(Request $request){


		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.salary.salary')->with(compact('employee'));

	}

	public function empsalary(Request $request){

		$employeeid = Input::get('employeeid');
		$year = Input::get('year');
		$month = Input::get('month');

		$if_exist = Salary::where('year', $year)->where('month', $month)->where('employeeid', $employeeid)->first();

		if(!empty($if_exist)){

			return redirect()->route('viewsalary')->with('error', 'Salary is already loacked');
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

		$employeelog = EmployeeLog::where('userid', $employeeid)->whereBetween('punchdate', [$fromdate, $todate])->where('checkout', null)->get()->all();

		$employee = Employee::where('status', 1)->get()->all();
		$error = 1;
		if(!empty($employeelog)){

			return view('admin.hr.employeelog.viewemployeelog')->with(compact('employeeid', 'year', 'month', 'employee', 'error'));

		}

		$employeelog = EmployeeLog::where('userid', $employeeid)->whereBetween('punchdate', [$fromdate, $todate])->get()->all();

		$employeelog_days = EmployeeLog::where('userid', $employeeid)->whereBetween('punchdate', [$fromdate, $todate])->groupBy('punchdate')->select('punchdate')->get()->all();

		$attenddays = count($employeelog_days);
		
		$totalminute = 0;
		$totalhour = 0;
		$totaldays = 0;
		$givenleave = 0;

		foreach($employeelog as $emplog){

			$difference = strtotime($emplog->checkout) - strtotime($emplog->checkin);

			$totalminute += $difference;

		}

		$noofleave = Leave::where('employeeid', $employeeid)->first();
		if(!empty($noofleave)){
			$givenleave = $noofleave->noofleave;
		}else{
			$givenleave = 0;
		}

		$empleave = EmployeeLeave::where('employeeid', $employeeid)->whereBetween('date', [$fromdate, $todate])->get()->all();
		$takenleave = count($empleave);

		$empdata = Employee::where('employeeid', $employeeid)->first();

		$empsalary = $empdata->salary;
		$empworkinghour = $empdata->workinghour;
		$empworkingminute = ($empworkinghour*60);

		$totalminute = ceil($totalminute / 60);
		$total_hour = ceil($totalminute / 60);

		$workingdays_data = WorkingDays::where('year', $year)->where('month', $month)->first();
		if(!empty($workingdays_data)){
			$Workindays = $workingdays_data->workingdays;
			$holidays = $workingdays_data->holidays;
		}else{
			$Workindays = 0;
			$holidays = 0;
		}

		$totalattenddays = $attenddays - $takenleave;

		$current_salary = round(($totalattenddays * $empsalary) / $Workindays);

		$store = !empty($request->store) ? $request->store : 0;

		if($store == 1){

			$if_exist = Salary::where('year', $year)->where('month', $month)->where('employeeid', $employeeid)->first();

			if(!empty($if_exist)){

				return redirect()->route('viewsalary')->with('error', 'Employee Salary is already locked');
			}

			$salary = new Salary();
			$salary->workingdays = $Workindays;
			$salary->attenddays = $attenddays;
			$salary->empworkingminute = $empworkingminute;
			$salary->totalminute = $totalminute;
			$salary->empworkinghour = $empworkinghour;
			$salary->totalhour = $total_hour;
			$salary->givenleave = $givenleave;
			$salary->takenleave = $takenleave;
			$salary->holidays = $holidays;
			$salary->empsalary = $empsalary;
			$salary->currentsalary = $current_salary;
			$salary->year = $year;
			$salary->month = $month;
			$salary->employeeid = $employeeid;
			$salary->status = 'Locked';
			$salary->actionby = session()->get('admin_id');

			$salary->save();

			return redirect()->route('viewsalary')->with('success', 'Employee Salary is locked');



		}

		return view('admin.hr.salary.calculatesalary')->with(compact('attenddays', 'totalminute', 'totalhour', 'totaldays', 'givenleave', 'takenleave', 'empdata', 'empsalary', 'empworkinghour', 'totalminute', 'total_hour', 'year', 'month', 'Workindays', 'holidays', 'empworkingminute', 'current_salary', 'employeeid'));




	}
}

	public function viewlockedsalary(Request $request){

		$salary = Salary::with('employee')->where('status', 'Locked')->get()->all();
		$employee  = Employee::where('status', 1)->get()->all();

		return view('admin.hr.salary.viewlockedsalary')->with(compact('salary', 'employee'));

	}


	public function viewsalary(){

		$salary = Salary::with('employee')->get()->all();

		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.salary.viewsalary')->with(compact('salary', 'employee'));

	}

	public function editsalary($id, Request $request){

		$salary = Salary::with('employee')->where('salaryid', $id)->first();

		return view('admin.hr.salary.editsalary')->with(compact('salary'));







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

			$empleave = Leave::where('employeeid', $employeeid)->first();
			$totalleave = $empleave->noofleave;

			$leavecount  = EmployeeLeave::where('employeeid', $employeeid)->get()->all();
			$leavecount = count($leavecount);

			if($leavecount > $totalleave){
				return back()->with('error', 'You can not add leave as lEmployee leaves are already used!');
			}

			$existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->first();
			if(!empty($existleave)){
				return back()->with('error', 'You can not add same leave!');

			}

			$employeeleave = new EmployeeLeave();
			$employeeleave->employeeid =  $employeeid;
			$employeeleave->date =  date('Y-m-d', strtotime($request->leavedate));
			$employeeleave->reason =  !empty($request->reason) ? $request->reason : null;
			$employeeleave->actionby = session()->get('admin_id');
			$employeeleave->Save();

			return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is added successfully.');

		}


		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeeleave.addemployeeleave')->with(compact('employee'));



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
			
			$existleave = EmployeeLeave::where('employeeid', $employeeid)->where('date', date('Y-m-d', strtotime($request->leavedate)))->first();
			if(!empty($existleave)){
				return back()->with('error', 'You can not add same leave!');

			}

			$empleave->date =  date('Y-m-d', strtotime($request->leavedate));
			$empleave->reason =  !empty($request->reason) ? $request->reason : null;
			$empleave->actionby = session()->get('admin_id');
			$empleave->Save();

			return redirect()->route('viewemployeeleave')->with('success', 'Employee leave is updated successfully');

			
		}


		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeeleave.editemployeeleave')->with(compact('empleave', 'employee', 'expirydate'));






	}

	public function viewemployeeleave(){

		$employeeleave = EmployeeLeave::all();
		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee'));


	}

	public function searchemployeeleave(Request $request){

		$employeeid = $request->employeeid;

		$employeeleave = EmployeeLeave::where('employeeid', $employeeid)->get()->all();
		$employee = Employee::where('status', 1)->get()->all();

		return view('admin.hr.employeeleave.viewemployeeleave')->with(compact('employeeleave', 'employee', 'employeeid'));

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


		$empexpirydate = EmployeeLeave::where('employeeid', $id)->first();
		$empexpirydate->delete();

		return redirect()->route('viewemployeeleave')->with('error', 'Employee leave is deleted');


	}







///////////////////////////////////// Employee Leave End ////////////////////////////////////////////////////////////////




}

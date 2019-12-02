<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Notify;

class ActivityReportController extends Controller
{
    public function activityreport(Request $request)
    {	
    	$fdate =$request->get('fdate');
		$tdate =$request->get('tdate');
		$username=$request->get('username');
		$keyword =$request->get('keyword');
		/*for pass to bladefile */
		$query=[];
		$query['fdate']=$fdate ;
		$query['tdate']=$tdate ;
		$query['username']=$username;
		$query['keyword']= $keyword;
		$users=Employee::where('status',1)->get()->all();

    	 if ($request->isMethod('post'))
   		 { 	
   		 	$data=Notify::select('notify.*','employee.first_name','employee.last_name')->leftjoin('employee','employee.userid','notify.userid');
   		 	   if ($fdate != "") {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                   $data->whereBetween('notify.created_at', [$from, $to]);
	                 
	       }
	       if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = '';
	                   }
	                     $data->whereBetween('notify.created_at', [$from, $to]);
	       }
	        if ($keyword != ""){
	             $data->where ( 'employee.first_name', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'employee.last_name', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'employee.username', 'LIKE', '%' . $keyword . '%' )->orWhere ('notify.details', 'LIKE', '%' . $keyword . '%' );
	        }
	        // dd($username);
	        if($username != ""){
	        	$data->where('employee.userid',$username);
	        }
	        // dd($paymentdata->paginate(5));
	       

	        $data=$data->paginate(8)->appends('query');
   		 	
   		 	return view('admin.activityreport.activityreport',compact('query','data','users'));
   		 }
   		 else
   		 {
   		 	$data=Notify::select('notify.*','employee.first_name','employee.last_name')->leftjoin('employee','employee.userid','notify.userid')->paginate(8);
   		 	return view('admin.activityreport.activityreport',compact('query','data','users'));
   		 }
    }
}

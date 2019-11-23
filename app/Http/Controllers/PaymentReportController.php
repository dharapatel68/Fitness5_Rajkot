<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentType;
use DB;

class PaymentReportController extends Controller
{
   public function paymentreport(Request $request)
   {

   		/*for Post request */
   		   $fdate =$request->get('fdate');
	          $tdate =$request->get('tdate');
	          $username=$request->get('username');
	          $mode=$request->get('mode');
	          $amount=$request->get('amount');
	          $keyword =$request->get('keyword');
				/*for pass to bladefile */
	          $query=[];
	          $query['fdate']=$fdate ;
	          $query['tdate']=$tdate ;
	          $query['username']=$username;
	          $query['mode']=$mode;
	          $query['amount']= $amount;
	          $query['keyword']= $keyword;


   		if($request->isMethod('post'))
    	{
    	
			$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
			
			$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
			$merged = $users1->merge($users2);
			$users = $merged->all();    
        
        	$modes=PaymentType::get(['paymenttype','paymenttypeid'])->all();

	        $paymentdata = DB::table('payments')
	        ->leftJoin('users', 'users.userid', '=', 'payments.userid')
	        ->leftJoin('member', 'member.memberid', '=', 'payments.memberid')
	        ->leftJoin('registration', 'registration.id', '=',  'users.regid')
	        ->leftJoin('company', 'company.companyid', '=', 'member.companyid')
	        ->leftJoin('admin', 'admin.adminid', '=', 'payments.takenby')
	        ->where('payments.mode', '!=', 'total')
	        ->select('users.userid as usertableuserid','users.*','payments.*','member.*','registration.firstname as rfirstname','registration.lastname as rlastname','payments.amount as pamount','company.companyname as companyname','admin.name as name');

	         if ($fdate != "") {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                   $paymentdata->whereBetween('date', [$from, $to]);
	                 
	       }
	       if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = '';
	                   }
	                     $paymentdata->whereBetween('date', [$from, $to]);
	       }
	        if ($keyword != ""){
	             $paymentdata->where ( 'member.firstname', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.firstname', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'registration.lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ('member.email', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'member.lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ('mode', 'LIKE', '%' . $keyword . '%' );
	        }
	        // dd($username);
	        if($username != ""){
	        	$paymentdata->where('users.userid',$username);
	        }
	        // dd($paymentdata->paginate(5));
	        if($amount != ""){
	        	$paymentdata->where('payments.amount',$amount);
	        }
	        if($mode != ""){
	        	$paymentdata->where('payments.mode',$mode);
	        }

	        $paymentdata=$paymentdata->paginate(8)->appends('query');
	        // dd($paymentdata);
	        return view('admin.paymentreport.paymentreport',compact('paymentdata','users','modes','query'));


    	}

   		/*for get request */

		$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();

		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();

		$modes=PaymentType::get(['paymenttype','paymenttypeid'])->all();

   		$paymentdata = DB::table('payments')
        ->leftJoin('users', 'users.userid', '=', 'payments.userid')
        ->leftJoin('member', 'member.memberid', '=', 'payments.memberid')
        ->leftJoin('registration', 'registration.id', '=', 'users.regid')
        ->leftJoin('company', 'company.companyid', '=', 'member.companyid')
        ->leftJoin('admin', 'admin.adminid', '=', 'payments.takenby')
        ->where('payments.mode', '!=', 'total')
        ->select('users.userid as usertableuserid','users.*','payments.*','member.*','registration.firstname as rfirstname','registration.lastname as rlastname','payments.amount as pamount','company.companyname as companyname','admin.name as name')
        ->paginate(8);
           /* dd($paymentdata);*/

   		
   		return view('admin.paymentreport.paymentreport',compact('paymentdata','users','modes','query'));

   

   }
}

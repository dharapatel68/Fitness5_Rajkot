<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberReportController extends Controller
{	
    public function memberreport(Request $request){

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

			$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();

   		if($request->isMethod('post'))
    	{	
   	
    			 if ($fdate != "") 
    			 {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate)) {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                  
    				$data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."' GROUP BY memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,dietassigndate,workoutassigndate ORDER BY member.createddate  ASC") );
    					$currentPage = LengthAwarePaginator::resolveCurrentPage();
						$itemCollection = collect($data);
						$perPage = 10;
						$currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
						$paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
						$paginatedItems->setPath($request->url());
						$data =  $paginatedItems;

    				 	return view('admin.memberreport.memberreport',compact('query','data','users'));
	                 
	      	 	 }
	      	 	 if ($tdate != "") {
	                   $to = date($tdate);
	                   if (!empty($fdate)) {
	                       $from = date($fdate);
	                   }else{
	                       $from = date('Y-m-d');
	                   }

	                  $data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid WHERE `member`.`createddate` BETWEEN '".$from."' AND '".$to."' GROUP BY  memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,dietassigndate,workoutassigndate ORDER BY member.createddate  ASC") );

	                  $currentPage = LengthAwarePaginator::resolveCurrentPage();
						$itemCollection = collect($data);
						$perPage = 10;
						$currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
						$paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
						$paginatedItems->setPath($request->url());
						$data =  $paginatedItems;
	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	      		 }
	      		 if($username != ""){

	        		$data=	 DB::select( DB::raw("select  `member`.memberid as memid, `memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `users`.`userid` = '".$username."' GROUP BY  as memid, `memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,dietassigndate, workoutassigndate  ORDER BY member.createddate  ASC") );

						$currentPage = LengthAwarePaginator::resolveCurrentPage();
						$itemCollection = collect($data);
						$perPage = 10;
						$currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
						$paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
						$paginatedItems->setPath($request->url());
						$data =  $paginatedItems;

	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }
	       		 if($keyword != ""){

	       		 			$data=	 DB::select( DB::raw("select   `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid  left join users on member.userid=users.userid WHERE `member`.`firstname` Like '%".$keyword."%' or  `member`.`lastname` Like '%".$keyword."%' GROUP BY  memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,dietassigndate, workoutassigndate  ORDER BY member.createddate  ASC") );


					$currentPage = LengthAwarePaginator::resolveCurrentPage();
					$itemCollection = collect($data);
					$perPage = 10;
					$currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
					$paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
					$paginatedItems->setPath($request->url());
					$data =  $paginatedItems;
	                  	return view('admin.memberreport.memberreport',compact('query','data','users'));
	       		 }

    			
		return view('admin.memberreport.memberreport',compact('query','data','users'));

    	}

			$data=	 DB::select( DB::raw("select  `member`.memberid as memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid,memberdietplan.created_at as dietassigndate,memberworkout.created_at as workoutassigndate from `member` left join `memberdietplan` on `memberdietplan`.`memberid` = `member`.`memberid` AND memberdietplan.status='1' left join dietplanname on memberdietplan.plannameid=dietplanname.dietplannameid  left join memberworkout on member.memberid = memberworkout.memberid AND memberworkout.status='1' left join workout on workout.workoutid= memberworkout.workoutid GROUP BY  `memberdietplan`.`memberid`,memid,`memberdietplan`.`memberdietplanid`,`member`.`createddate`,`member`.`firstname`,`member`.`lastname`,dietplanname.dietplanname,workout.workoutname,memberworkout.workoutid, dietassigndate,workoutassigndate ORDER BY member.createddate ASC") );

	
		$users1=  DB::table('users')->join('registration','registration.id','users.regid')->where('users.regid','!=',0)->where('registration.is_member','!=',1)->where('users.useractive',1)->get();
		$users2= DB::table('users')->Join('member', 'member.userid', '=', 'users.userid')->get();
		$merged = $users1->merge($users2);
		$users = $merged->all();

  $currentPage = LengthAwarePaginator::resolveCurrentPage();
  $itemCollection = collect($data);
   $perPage = 10;
    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
      $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
       $paginatedItems->setPath($request->url());
       $data =  $paginatedItems;


		return view('admin.memberreport.memberreport',compact('query','data','users'));
	}
	
}

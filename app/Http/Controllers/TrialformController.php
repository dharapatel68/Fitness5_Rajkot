<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Employee;
use App\TrainerProfile;
use App\Notify;
use App\Ptlevel;
use App\trialform;
use DB;
use App\Ptassignlevel;
class TrialformController extends Controller
{
public function edittrialform($trailformid,Request $request)
{ 
	$trialform= trialform::select('trialform.*','employee.first_name as first_name','employee.last_name as last_name')->leftjoin('employee','trialform.employeeid','employee.employeeid')-> where('trialform.status','Active')->where('trialform.trailformid',$trailformid)->first();
	// $trialform=trialform::findOrFail($trailformid);
	$method = $request->method();
	if ($request->isMethod('post')){
		$trialform->remarks=$request->rating;
		$trialform->remarks2=$request->remarks2;
		$trialform->timing=$request->timing;
		$trialform->date=$request->date;
		$trialform->clientname=$request->clientname;
		$trialform->mobileno=$request->mobileno;
		$trialform->employeeid=$request->trainerid;
		$trialform->level=$request->level;
		$trialform->pt=$request->pt;
		$trialform->gt=$request->gt;
		$trialform->save();
	return redirect('viewtrialform')->withSuccess('Details Succesfilly Edited');
	}
	$trainer=Employee::where('roleid',4)->get()->all();
	$levels=Ptlevel::get()->all();
return view('admin.trail.edittrialform',compact('trialform','trainer','levels'));
}
public function viewtrialform(Request $request)
{


    	$fdate =$request->get('fdate');
		$tdate =$request->get('tdate');
		
		
		$query=[];
		$query['fdate']=$fdate ;
		$query['tdate']=$tdate ;
		
		
		
    	 if ($request->isMethod('post'))
   		 { 	
   		 	$data=trialform::select('trialform.*','employee.first_name','employee.last_name')->join('employee', 'employee.employeeid', '=', 'trialform.employeeid')->where('trialform.status', '=','Active')->orderBy('trailformid','desc')->paginate(8);

		$trialform1=trialform::where('status','Active')->orderBy('trailformid','desc')->paginate(8);
   		 	   if ($fdate != "")
   		 	    {
	                   $from = date($fdate);
	                   //$to = date($to);
	                   if (!empty($tdate))
	                    {
	                       $to = date($tdate);
	                   }else{
	                       $to = date('Y-m-d');
	                   }
	                   // ->whereBetween('followupdays', [$from, $to])
	                   $data->whereBetween('trialform.date', [$from, $to]);
	                 
	       }
	       if ($tdate != "")
	        {
	                   $to = date($tdate);
	                   if (!empty($fdate))
	                    {
	                       $from = date($fdate);
	                   }else{
	                       $from = '';
	                   }
	                     $data->whereBetween('trialform.date', [$from, $to]);
	       }
	       
	       
	        $data=$data->paginate(8)->appends('query');
   		 	
   		 	return view('admin.trail.viewtrialform',compact('query','data','trialform1'));
   		 }
   		 else
   		 {
   		 	
	$data=trialform::select('trialform.*','employee.first_name','employee.last_name')->join('employee', 'employee.employeeid', '=', 'trialform.employeeid')->where('trialform.status', '=','Active')->orderBy('trailformid','desc')->paginate(8);
	$trialform1=trialform::where('status','Active')->orderBy('trailformid','desc')->paginate(8);
   		 	return view('admin.trail.viewtrialform',compact('query','data','trialform1'));
   		 }

}
public function trialform(Request $request)
{
$method = $request->method();
if ($request->isMethod('post'))
{
$trialform =  trialform::create([            
'remarks2' => $request->input('remarks2'),
'timing' => $request->input('timing'),
'remarks' => $request->input('rating'),
'date' => $request['date'],
'clientname' => $request['clientname'],
'mobileno' => $request['mobileno'],
'employeeid' => $request['trainerid'],
'level' => $request['level'],      
'pt' => $request['pt'],
'gt' => $request['gt']
]);
return redirect('viewtrialform')->withSuccess('Details Succesfilly Added');
}
else
{
$trainer=Employee::where('roleid',4)->get()->all();
$levels=Ptlevel::get()->all();
$ptassignlevel = DB::table('ptassignlevel')->leftJoin('employee', 'ptassignlevel.trainerid', '=', 'employee.employeeid')->OrderBy('ptassignlevelid','desc')->get();
return view('admin.trail.trialform',compact('trainer','levels','ptassignlevel'));
}
}
}
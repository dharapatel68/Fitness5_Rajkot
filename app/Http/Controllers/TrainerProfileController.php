<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\TrainerProfile;

class TrainerProfileController extends Controller
{
    public function addtrainerprofile(Request $request){
    	 if ($request->isMethod('post')){

		   
    	 	$trainerprofile=TrainerProfile::create([

	            'employeeid' => $request['trainerid'],
	            'leveloftrainer' => $request['level'],
	            'city' => $request['city'],
	            'exp' => $request['exp'],
	            'achievments' => $request['achievments'],
	            'freeslots'=> $request['slots'],
	            'photo' => $request['photo'],
	            
	     
    	 	]);
    	 	 if($request->hasfile('results'))
		    {
		      foreach($request->file('results') as $file)
		      {
		        $name=$file->getClientOriginalName();
		         $name= $name.'_'.$request['trainerid'];
		        $file->move(public_path().'/files/', $name);  
		        $data[] = $name;  
		      }
		
		      $trainerprofile->results=json_encode($data);
		 
		      $trainerprofile->save();
		    }
		    if($file = $request->file('photo')){

	           $file_name = $file->getClientOriginalName();
	           $file_size = $file->getClientSize();
	            $file_name= $file_name.'_'.$request['trainerid'];
	           $file->move(public_path().'/files/', $file_name);

	           $photo = $file_name;
	           $trainerprofile->photo= $photo;
	           $trainerprofile->save();
          	}
          	return redirect('viewtrainers')->withSuccess(['Successfully Added']);
    	 }
    	 else{
    	 	$trainer=Employee::where('roleid',4)->get()->all();
    		return view('admin.Trainer.addtrainerprofile',compact('trainer'));
    	 }
    	

    }
    public function viewtrainers(Request $request){
    	
		$fdate =$request->get('fdate');
		$tdate =$request->get('tdate');
		$username=$request->get('username');
		$keyword =$request->get('keyword');
		/*for pass to bladefile */
		$query=[];
		$data = array('' => , );;
		$query['fdate']=$fdate ;
		$query['tdate']=$tdate ;
		$query['username']=$username;
		$query['keyword']= $keyword;    	
    	return view('admin.Trainer.viewtrainers',compact('query','data'));
    }
}

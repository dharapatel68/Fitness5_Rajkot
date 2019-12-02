<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\TrainerProfile;
use App\Notify;

class TrainerProfileController extends Controller
{
    public function addtrainerprofile(Request $request){
    	 if ($request->isMethod('post')){
    	 	$messages = [
          'unique' => 'This Trainer already have profile'];
		  	 $request->validate([
              	'trainerid' => 'required|unique:trainerprofile,employeeid',
              	'photo' => 'mimes:jpeg,bmp,png|max:2000',
    			'results.*' => 'mimes:jpeg,bmp,png|max:2000',
            ],$messages);

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
		         $name= $request['trainerid'].'_'.$name;
		        $file->move(public_path().'/files/', $name);  
		        $data[] = $name;  
		      }
		
		      $trainerprofile->results=json_encode($data);
		 
		      $trainerprofile->save();
		    }
		    if($file = $request->file('photo')){

	           $file_name = $file->getClientOriginalName();
	           $file_size = $file->getClientSize();
	            $file_name= $request['trainerid'].'_'.$file_name;
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
		$data = array( );
		$query['fdate']=$fdate;
		$query['tdate']=$tdate;
		$query['username']=$username;
		$query['keyword']= $keyword;  
		$data= TrainerProfile::leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->paginate(8);  	
    	return view('admin.Trainer.viewtrainers',compact('query','data'));
    }
    public function viewtrainerprofile(Request $request,$id){
    	$trainerprofile=TrainerProfile::leftjoin('employee','employee.employeeid','trainerprofile.employeeid')->where('trainerprofile.trainerprofileid',$id)->get(['trainerprofile.photo as trainerphoto','trainerprofile.city as trainercity','trainerprofile.*','employee.*'])->first();
    	 // dd($trainerprofile);
    	$timeline=Notify::where('userid',$trainerprofile)->get()->all();
    
    	return view('admin.Trainer.viewtrainerprofile',compact('trainerprofile','timeline'));
    }
}
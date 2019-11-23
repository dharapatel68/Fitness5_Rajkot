<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Measurement;
use DB;

class MeasurementController extends Controller
{
     public function addMeasurement(Request $request)
    {   


              $method = $request->method();
              if ($request->isMethod('post')){

              $request->validate([
              'selectusername' => 'required',
              'weight' => 'numeric|nullable',
              'height' => 'numeric|nullable',
              'neck' => 'numeric|nullable',
              'leftupperarm' => 'numeric|nullable',
              'rightupperarm' => 'numeric|nullable',
              'chest' => 'numeric|nullable',
              'leftthigh' => 'numeric|nullable',
              'rightthigh' => 'numeric|nullable',
              'leftcalf' => 'numeric|nullable',
              'rightcalf' => 'numeric|nullable',
              'waist' => 'numeric|nullable',
              'hips' => 'numeric|nullable',

              ]);

              Measurement::create([
                'todaydate'=>$request['todaydate'],
                'memberid'=>$request['selectusername'],
                'weight'=>$request['weight'],
                'height'=>$request['height'],
                'neck'=>$request['neck'],
                'leftupperarm'=>$request['leftupperarm'],
                'rightupperarm'=>$request['rightupperarm'],
                'chest'=>$request['chest'],
                'leftthigh'=>$request['leftthigh'],
                'rightthigh'=>$request['rightthigh'],
                'leftcalf'=>$request['leftcalf'],
                'rightcalf'=>$request['rightcalf'],
                'waist'=>$request['waist'],
                'hips'=>$request['hips'],
              ]);
            return  redirect('viewMeasurement')->with('message','Succesfully Added');
              }
               $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->where('member.status',1)->get()->all();
       return  view('admin.measurement.addMeasurement',compact('users'));
       
    }
    public function measurementgetuser(Request $request){
    	$id=$request->get('username');
    	$request->get('MobileNo');
    	$user=Member::where('memberid',$id)->get()->first();
    	echo json_encode($user);

    }
     public function viewMeasurement(Request $request)
    {
        
        if($request->isMethod('post'))

    {
       
       if($request->get('from')!="")
        {
         
        $from = date($request->get('from'));
        if($request->get('to')){
          $to = date($request->get('to'));
        }
        else{
          $to = date('Y-m-d');
        }
           $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $measurement = Measurement::whereBetween('todaydate', [$from, $to])->get()->all();
        
          return view('admin.measurement.viewMeasurement',compact('users','measurement'));
      }
      else if($request->get('to')!="")
      {
        
        $to = date($request->get('to'));
        if($request->get('from')){
          $from = date($request->get('from'));
        }
        else{
          $from = date('Y-m-d');
        }
        $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $measurement = Measurement::whereBetween('todaydate', [$from, $to])->get()->all();
        
          return view('admin.measurement.viewMeasurement',compact('users','measurement'));
      }
      else if($request->get('selectusername')!="")
      {

        $id=$request->get('selectusername');

        // dd($status);
         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $measurement = Measurement::where('memberid',$id)->get()->all();

        return view('admin.measurement.viewMeasurement',compact('users','measurement'));
      }

      else{
               $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
      $measurement=Measurement::get()->all();

        return view('admin.measurement.viewMeasurement',compact('users','measurement'));
      }

      
      }
         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
         $measurement=Measurement::with('Member')->get()->all();
         // dd($measurement);

        return view('admin.measurement.viewMeasurement',compact('users','measurement'));
     }
     public function editMeasurement(Request $request,$id)
     {
      
        $method = $request->method();
        if ($request->isMethod('post')){

              $request->validate([
              'selectusername' => 'required',
              'weight' => 'numeric|nullable',
              'height' => 'numeric|nullable',
              'neck' => 'numeric|nullable',
              'leftupperarm' => 'numeric|nullable',
              'rightupperarm' => 'numeric|nullable',
              'chest' => 'numeric|nullable',
              'leftthigh' => 'numeric|nullable',
              'rightthigh' => 'numeric|nullable',
              'leftcalf' => 'numeric|nullable',
              'rightcalf' => 'numeric|nullable',
              'waist' => 'numeric|nullable',
              'hips' => 'numeric|nullable',

              ]);

        
         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $editmeasurement=Measurement::where('measurementid',$id)->get()->first();
          $editmeasurement->todaydate=$request['todaydate'];
          $editmeasurement->memberid=$request['selectusername'];
          $editmeasurement->weight=$request['weight'];
          $editmeasurement->height=$request['height'];
          $editmeasurement->neck=$request['neck'];
          $editmeasurement->leftupperarm=$request['leftupperarm'];
          $editmeasurement->rightupperarm=$request['rightupperarm'];
          $editmeasurement->chest=$request['chest'];
          $editmeasurement->leftthigh=$request['leftthigh'];
          $editmeasurement->rightthigh=$request['rightthigh'];
          $editmeasurement->leftcalf=$request['leftcalf'];
          $editmeasurement->rightcalf=$request['rightcalf'];
          $editmeasurement->waist=$request['waist'];
          $editmeasurement->hips=$request['hips'];
          $editmeasurement->save();
          return  redirect('viewMeasurement')->with('message','Succesfully Edited');       
                 }
            $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
        $editmeasurement=Measurement::where('measurementid',$id)->get()->first();              
        return view('admin.measurement.editMeasurement',compact('editmeasurement','users'));
     }
}

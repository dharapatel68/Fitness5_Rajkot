<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Member;
use App\ExerciseProgram;
use DB;
use App\Notify;
use App\User;
use App\MemberPackages;
use App\Fitnessgoals;
use App\RootScheme;
use App\Scheme;
use App\Payment;
use App\PaymentType;
use App\AdminMaster;
use App\PaymentDetails;
use Illuminate\Support\Facades\Hash;
use App\Company;
use App\Files;
use App\SendCode;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Inquiry;
use Carbon\Carbon;
use App\OTPVerify;
use App\Followup;
use Ixudra\Curl\Facades\Curl;
use App\Notes;
use App\Biomatric;
use Session;
use App\Actionlog;
use DataTables;
use App\Registration;
use App\UserTrack;
use App\Deviceusers;
use App\Apicheck;
use App\Notification;
use App\Notificationmsgdetails;
use App\Emailnotificationdetails;
use App\Smssetting;
use App\Emailsetting;
use App\MemberData;
 use Illuminate\Support\Facades\Mail;
 use Illuminate\Pagination\LengthAwarePaginator;



class MemberController extends Controller
{
  public function index(Request $request)
  {
       if($request->isMethod('post'))
    {
          $fdate =$request->get('from');

          $tdate =$request->get('to');

          $username=$request->get('username');

          $mobileno=$request->get('mobileno');
          $keyword =$request->get('keyword');

          $smsmale = '';
          $smsfemale = '';
          $query=[];
          $query['fdate']=$fdate ;
          $query['tdate']=$tdate ;
          $query['mobileno']=$mobileno;
          $query['username']=$username;
          $query['keyword']= $keyword;
            
           

         $members = Member::leftJoin('users','member.userid','=','users.userid')->orderBy('member.created_at', 'desc');
         if ($fdate != "") {
                   $from = date($fdate);
                   //$to = date($to);
                   if (!empty($tdate)) {
                       $to = date($tdate);
                   }else{
                       $to = date('Y-m-d');
                   }
                   // ->whereBetween('followupdays', [$from, $to])
                   $members->whereBetween('createddate', [$from, $to]);
                 
       }
        if ($keyword != ""){
             $members->where ( 'firstname', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'member.email', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'lastname', 'LIKE', '%' . $keyword . '%' )->orWhere ( 'city', 'LIKE', '%' . $keyword . '%' );
        }
     
       if ($tdate != "") {
                   $to = date($tdate);
                   if (!empty($fdate)) {
                       $from = date($fdate);
                   }else{
                       $from = date('Y-m-d');
                   }
                     $members->whereBetween('createddate', [$from, $to]);
       }
         if ($username != "") {
                  $members->where('member.userid','=',$username);
          }
        if ($mobileno != "") {
                  $members->where('member.userid','=',$mobileno);
          } 

         $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
   
         $members= $members->get()->all();

          return view('admin.members',compact('members','users','query'));
    }
    else
    {
         $members = Member::leftJoin('users','member.userid','=','users.userid')->orderBy('member.created_at', 'desc')->paginate(8);

        $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();

         return view('admin.members',compact('members','users'));
    }
  }
//   public function index45(Request $request)
//   {


//     if($request->isMethod('post'))
//     {

//       if($request->get('username')!="")
//       {
//         $userid=$request->get('username');

//         $members = Member::leftJoin('users','member.userid','=','users.userid')->where('member.userid','=',$userid)->paginate();

//         $userid_con=$request->get('username');
        

//           // dd($members);
//          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//         return view('admin.members',compact('members','users', 'userid_con'));
//       }
//       elseif($request->get('mobileno')!="")
//       {
//         $userid=$request->get('mobileno');

//         $members = Member::leftJoin('users','member.userid','=','users.userid')->where('member.userid','=',$userid)->paginate();

//         $userid_mobile=$request->get('mobileno');
      

//           // dd($members);
//          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//         return view('admin.members',compact('members','users', 'userid_mobile'));
//       }
//       elseif($request->get('from')!="")
//       {

//         $from_display = date($request->get('from'));
//         $to_display = $request->get('to');
//         if($request->get('to')){
//           $to = date($request->get('to'));
//         }
//         else{
//           $to = date('Y-m-d');
//         }
//         $members = Member::leftJoin('users','member.userid','=','users.userid')->whereBetween('createddate', [$from_display, $to])->paginate(8);
//           //dd($members);
//          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//         return view('admin.members',compact('members','users', 'from_display', 'to_display'));
//       }
//        elseif($request->get('to')!="")
//       {

//         $to_display = date($request->get('to'));
//         $from_display = date($request->get('from'));
//         if($request->get('from')){
//           $from = date($request->get('from'));
//         }
//         else{
//           $from = date('Y-m-d');
//         }
//         $members = Member::leftJoin('users','member.userid','=','users.userid')->whereBetween('createddate', [$from, $to_display])->paginate(8);
//           // dd($members);
//          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//         return view('admin.members',compact('members','users', 'from_display', 'to_display'));
//       }
//       elseif($request->get('keyword')!="")
//       {
//         $userid=$request->get('keyword');
//         $key_word = $request->get('keyword');
//         $members = Member::leftJoin('users','member.userid','=','users.userid')->where ( 'firstname', 'LIKE', '%' . $userid . '%' )->orWhere ( 'member.email', 'LIKE', '%' . $userid . '%' )->orWhere ( 'lastname', 'LIKE', '%' . $userid . '%' )->orWhere ( 'city', 'LIKE', '%' . $userid . '%' )->paginate(6);
//          $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//         if (count ($members) > 0)
//          return view('admin.members',compact('members','users', 'key_word'));
//        else
//         $members ='';
//       return view('admin.members',compact('members','users','key_word'));
      
//         //return view('admin.members',compact('members','users'));
//     }


//     $members = Member::leftJoin('users','member.userid','=','users.userid')->paginate(8);
//    $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();


      
//        // $members = Member::sortable()->paginate(6);
  
//     return view('admin.members',compact('members','users'));
//   }

//   else
//   {

//   $members = Member::leftJoin('users','member.userid','=','users.userid')->orderBy('member.created_at', 'desc')->paginate(8);

//      $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();

//     return view('admin.members',compact('members','users'));
//   }
// }

public function scheme(Request $request)
{
  $id=$request->get('name');
  $mid=$request->get('id');
  $member=Member::where('memberid',$mid)->get()->first();

  $gender=$member->gender;


  if($gender=='Female'){

   $row=DB::table('schemes')->select('schemeid','schemename','numberofdays','male','female')->where('female',1)->where('rootschemeid','=',$id)->where('validity','>=', Carbon::now())->where('status','1')->get();
 }
 elseif($gender=='Male'){

   $row=DB::table('schemes')->select('schemeid','schemename','numberofdays','male','female')->where('male',1)->where('rootschemeid','=',$id)->where('validity','>=', Carbon::now())->where('status','1')->get();
 }
 echo json_encode($row);
}
public function idpendingreport(Request $request){
    
             $members = DB::select( DB::raw('select * from `member` left join `files` on `member`.`memberid` = `files`.`memberid` ,`memberpackages` where `files`.`memberid` is null and memberpackages.memberpackagesid = (SELECT MAX(memberpackages.memberpackagesid) FROM memberpackages where member.userid = memberpackages.userid)')); 

//               $currentPage = LengthAwarePaginator::resolveCurrentPage();
//   $itemCollection = collect($members);
//    $perPage = 10;
//     $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
//       $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
//        $paginatedItems->setPath($request->url());


// dd($members);
 // $members = DB::select( DB::raw('select * from `member` left join `files` on `member`.`memberid` = `files`.`memberid` ,`memberpackages` where `member`.`status` = 1 where `files`.`memberid` is null and memberpackages.memberpackagesid = (SELECT MAX(memberpackages.memberpackagesid) FROM memberpackages where member.userid = memberpackages.userid)')); 

 // return view('admin.IdPendingReport')->with(['members' => $paginatedItems]);
 return view('admin.IdPendingReport',compact('members'));
}
public function check(Request $request)
{
  $username=$request->get('username');
  $regid=$request->get('regid');
  $row=DB::table('users')->where('regid','!=',$regid)->select('username')->where('username','=',$username)->get();

  if(count($row)<=0)
  {
    echo 'unique';
  }
  else
  {
    echo 'not_unique';
  }
}
public function checkmobile(Request $request)
{
  $usermobile=$request->get('usermobile');
  $row=DB::table('users')->select('usermobileno')->where('usermobileno','=',$usermobile)->get();

  if(count($row)<=0)
  {
    echo 'unique';
  }
  else
  {
    echo 'not_unique';
  }
}


public function otpverify(Request $request){
  
 if ($request->isMethod('post'))
 {
/*****************************commit rollback*****************************************/

      if($request->filefrommember!='' || $request->filefrommember!= null){
        $request->validate([
        'CellPhoneNumber' => 'required|max:11|min:10',
        'lastname' => 'required|max:255',
        'firstname' => 'required',
        'gender' =>'required',
        ]);
        $photo=$request->filefrommember;
      }
    else{
      $request->validate([

        'CellPhoneNumber' => 'required|max:11|min:10',
        'lastname' => 'required|max:255',
        'firstname' => 'required',
        'gender' =>'required',
        'file' => 'mimes:jpeg,bmp,png|max:5000',
        'attachments.*' => 'mimes:jpeg,bmp,png|max:5000',
        
      ]);
       $photo='';
    }
       
   /*************try code**************************/
      DB::beginTransaction();
     try {
       $mobileno=$request['CellPhoneNumber'];
       $password= $request->get('username');
       $username=$request->get('username');

       $memberexist = Member::where('mobileno',$request['CellPhoneNumber'])->get()->all();
        $usr = User::Where('usermobileno',$request['CellPhoneNumber'])->get()->first();
      
        if($usr){
            $memberexistsameuserid = Member::where('userid',$usr->userid)->get()->all();
         if($memberexistsameuserid){
        return redirect('addMember')->with('message','User Already exists');
          }
        }
      


      if($memberexist){
        return redirect('addMember')->with('message','User Already exists');
      }
      if($request->get('memfromreg')){


         $regusrexist = User::where('regid','!=',$request->get('register_id'))->where('username',$username)->get()->first();
         if($regusrexist){
            return redirect('addMember')->with('message','User Already exists');
         }
        
      }

  
        // $usrnameexist = User::where('username',$username)->get()->first();
        //  if($usrnameexist){
        //     return redirect('addMember')->with('message','User Already exists');
        //  }


     $mobile=$request['CellPhoneNumber'];
     $password=$username;
     $q = Inquiry::where('mobileno',$mobile)->get()->first();
      if($q){
       $closeinquiry=Inquiry::where('mobileno',$mobile)->get()->first();
       $closeinquiry->status = '3';
       $closeinquiry->reason = 'Converted Into Member';
       $closeinquiry->save(); 

        if(Followup::where('inquiryid',$closeinquiry->inquiriesid)->get()->all()){

          $followup = Followup::where('inquiryid',$closeinquiry->inquiriesid)->get()->all();
          foreach($followup as $follow){
          $follow->status = '2';
          $follow->reason = 'Converted Into Member';
          $follow->save();
         }
       }
   
        $last_id = $closeinquiry->inquiriesid;
        $action = new Actionlog();
        $action->user_id = session()->get('admin_id');
        $action->ip = $request->ip();
        $action->action_type = 'convert';
        $action->action = 'inquiry converted to member';
        $action->action_on = $last_id;
        $action->save();
 
      }

      $reg_id='';

    
      if(!$request->get('memfromreg')){
        $registration= Registration::create([
          'firstname'=> $request->get('firstname'),
          'lastname' => $request->get('lastname'),
          'phone_no' => $request['CellPhoneNumber'],
          'dob'=>$request['birthday'],
          'gender'=> $request['gender'],
          'email_id' => $request['email'],
          'credit_validity_day' => '1',
          'timing' => $request->get('timing'),
          'starting_date' =>$request->get('timing'),
          'due_date' => date("Y-m-d", strtotime($request->input('duedate'))),
          'ending_date' => $request->get('timing'),
          'department_id' => $request->input('department'),
          'therapist_id' => $request->input('therapist'),
          'package_id' => $request->input('package'),
          'is_member'=>'1',
          'regtypeid'=>'0',
          'created_at'=>now(),
          'updated_at'=>now(),

        ]);
      $reg_id = $registration->id;
    }
    else{
      $reg_id=$request->get('register_id');
    }

    $reg = Registration::where('id', $reg_id)->first();

    if(!empty($reg)){
      $reg->is_member = 1;
      $reg->save();
    }

    $mpin=rand(1000, 9999);

    $usr = User::where('username', $request['username'])->orWhere('usermobileno',$request['CellPhoneNumber'])->get()->first();

   

    if($usr){
      $usr->userstatus = 'mem';

      $usr->save();
      $userid= $usr->userid;
    }

    else{
      $row1=User::create([
        'memid'=>'0',
        'username'=> $request->get('username'),
        'usermobileno'=>   $request['CellPhoneNumber'],
        'userpassword'=>$password,  
        'useremail'=>$request['email'],
        'useractive'=>'1',
        'userstatus'=>'mem'
      ]);
      $userid= $row1->userid;
    }


    $todayDate = date("Y-m-d");
    $usermember =  Member::create([
      'userid' => $userid,
      'createddate' =>  $todayDate,
      'lastname' => $request->get('lastname'),
      'firstname' =>  $request->get('firstname'),
      'gender' => $request['gender'],
      'address' => $request['Address'],
      'city' => $request['City'],
      'email' => $request['email'],
      'hearabout' => $request['HearAbout'],
      'formno' => $request['FormNo'],
      'homephonenumber' => $request['HomePhoneNumber'],
      'mobileno' => $request['CellPhoneNumber'],
      'officephonenumber' => $request['OfficePhoneNumber'],
      'profession' => $request['profession'],
      'birthday' => $request['birthday'],
      'anniversary' => $request['anniversary'],
      'emergancyname' => $request['emergancyname'],
      'emergancyrelation' => $request['emergancyrelation'],
      'emergancyaddress' => $request['emergancyaddress'],
      'emergancyphonenumber' => $request['EmergancyPhoneNumber'],
      'workinghourfrom' =>  Carbon::parse($request['working_hour_from_1']),
      'workinghourto' => Carbon::parse($request['working_hour_to_1']),
      'companyid' => $request['bycompany'],
      'bloodgroup'=>$request['bloodgroup'],
      'memberpin' => $mpin,

    ]);
    



   //  $notification = [
   //                   'mobileno' => $request['CellPhoneNumber'],
   //                   'sms'  =>'1',
   //                   'email' => '1',
   //                   'call' => '1',
   //             ];
   // DB::table('notification')->insert($notification);
   

    $formemidinsert=User::where('userid',$userid)->get()->first();

    if($usr){
      $usr->memid = $usermember->memberid;
      $formemidinsert->regid =$reg_id;
      $usr->save();
    }
    /*for memberid insert */
    if($formemidinsert){
      $formemidinsert->memid = $usermember->memberid;
      $formemidinsert->regid =$reg_id;
      $formemidinsert->save();
    }
    $memberdata=MemberData::where('mobileno',$request['CellPhoneNumber'])->where('status',1)->where('answer',2)->get()->first();
    if($memberdata){
      $memberdata->answer = 1;
      $memberdata->save();
    }
     
    if($request->filefrommember!='' || $request->filefrommember!= null){
      $usermember->photo= $photo;
      $usermember->save();
    }
    if($file = $request->file('file')){
      $file_name = $file->getClientOriginalName();
      $file_size = $file->getSize();
      /******************************* */
      $file_size = $file->getSize();
      /******************************** */
      $filename = public_path('/files/' . $file_name);
      if ($file_size > 5000000)
      {
          /*$img = Image::make($file->getRealPath())
              ->fit(400, 300)
              ->save($filename, 80);*/
         
      }
      else
      {
          $file->move(public_path() . '/files/', $file_name);
         
      }
     
      /****************************** */
      $photo = $file_name;
      $usermember->photo= $photo;
      $usermember->save();
    }
    
    if($request->base64image){
      $data = Input::all();
      $png_url = "perfil-".time().".jpg";
      $path = public_path() . "/files/" . $png_url;
      $img = $data['base64image'];
      $img = substr($img, strpos($img, ",")+1);
      $data = base64_decode($img);
      $success = file_put_contents($path, $data);
      $file_name=$png_url;
      $photo = $file_name;
      $usermember->photo= $photo;
      $usermember->save();
    }
         $notificationdnd = Notification::where('mobileno',$request['CellPhoneNumber'])->first();

        $notification = [

                    'mobileno' =>$request['CellPhoneNumber'],
                    'sms'  =>'1',
                    'email' => '1',
                    'call' => '1',
                   ];

        if ($notificationdnd) {

           Notification::where('mobileno',$request['CellPhoneNumber'])->update($notification);

        }else{

           DB::table('notification')->insert($notification);

        }

    $MemberId = $usermember->memberid;

    if($request->hasfile('attachments'))
    {
      foreach($request->file('attachments') as $file)
      {
        $name=$file->getClientOriginalName();
        $name= $name.'_'.$request['username'];

        if ($file_size > 5000000)
        {
          $filename =public_path('/files/'.$name);
            /*$img = Image::make($file->getRealPath())
                ->fit(400, 300)
                ->save($filename, 80);*/
        }
        else
        {
          $file->move(public_path().'/files/', $name);  
        }
        $data[] = $name;  
      }
      $file = new Files();
      $file->filename=json_encode($data);
      $file->memberid = $MemberId;
      $file->save();
    }

    $fitnessgoals =  $request->get('fitnessgoals');
    $fitnessgoal = DB::getSchemaBuilder()->getColumnListing('fitnessgoals');
    $i=0;
    $n0=0;
    $n0=count($fitnessgoal);

    Fitnessgoals::create([
      'memberid' => $usermember->memberid,
      'otherhelp'=> $request['OtherHelp'],
      'specificgoalsa'=> $request['SpecificGoalsa'],
      'specificgoalsb'=> $request['SpecificGoalsb'],
      'specificgoalsc'=> $request['SpecificGoalsc'],
    ]);


    if($fitnessgoals!=null){
      $fg1 = Fitnessgoals::get()->first()->getFillable();
      $fg = Fitnessgoals::where('memberid', $usermember->memberid)->first();
      $n=0;
      $n=count($fitnessgoals);

      $n1=0;
      $n1 = count($fg1);

      for($i=0; $i<=$n1-2; $i++){
        for($j=0;$j<$n;$j++){
          if($fitnessgoals[$j] == $i){
            $col= $fg1[$i];
            $fg->$col = "1";
          }
        }
      }
      $fg->save();
    }
// ***********************EXERCISE ENTRY******************************  //

    $exerciseprograms =  $request->get('exerciseprograms');

    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprograms');
    $i=0;
    $n0=0;
    $n0=count($exerciseprogram);

    ExerciseProgram::create([
      'memberid' => $usermember->memberid,
      'otheractivity'=> $request['OtherActivity'],
      'oftenweekexercise' =>  $request['OftenWeekExercise'],
    ]);

    if($exerciseprograms!=null){
      $ep1 = ExerciseProgram::get()->first()->getFillable();
      $ep = ExerciseProgram::where('memberid', $usermember->memberid)->first();
      $n=0;
      $n = count($exerciseprograms);
      $n1=0;
      $n1 = count($ep1);

      for($i=0; $i<=$n1-2; $i++){
        for($j=0;$j<$n;$j++){
          if($exerciseprograms[$j] == $i){
            $col = $ep1[$i];
            $ep->$col = "1";
          }
        }
      }
      $rank=$request['rank'];
      $goal=$request['goal'];
      if($rank=="h1")
      {
       $rh=1;
      }else {
      $rh=0;
      }
      if($rank=="m1")
      {
        $rm=1;
      }else{
        $rm=0;
      }
      if($rank=="l1")
      {
        $rl=1;
      }else{
        $rl=0;
      }
      if($goal=="v1")
      {
       $gv=1;
      }else{
       $gv=0;
      }
      if($goal=="s1")
      {
        $gs=1;
      }else{
        $gs=0;
      }
      if($goal=="b1")
      {
        $gb=1;
      }else{
        $gb=0;
      }

      $ep->highpriority=$rh;
      $ep->mediumpriority=$rm;
      $ep->lowpriority=$rl;

      $ep->very=$gv;
      $ep->semi=$gs;
      $ep->barely=$gb;

      $ep->save();
    }

    $actionbyid=Session::get('employeeid');


    $notify=Notify::create([
      'userid'=>  $userid,
      'details'=> 'User has taken Membership',
       'actionby' =>$actionbyid,
    ]);

    /**logs for pin change **/
       $last_id = $usermember->memberid;
       $action = new Actionlog();
       $action->user_id = session()->get('admin_id');
       $action->ip = $request->ip();
       $action->action_type = 'insert';
       $action->action = 'member';
       $action->action_on = $last_id;
       $action->save();
     /**Endlogs for pin change **/

      $mem = Member::where('mobileno',$mobileno)->get()->first();
      $fname=$mem->firstname;
      $lname=$mem->lastname;
      $fname=ucfirst($fname);
      $lname=ucfirst($lname);
      $msg=   DB::table('messages')->where('messagesid','2')->get()->first();

      $msg =$msg->message;

      $msg = str_replace("[FirstName]",$fname,$msg);
      $msg= str_replace("[LastName]",$lname,$msg);
      $msg2 = $msg;
      

      $memberi= Member::where('mobileno',$mobileno)->get()->first();
      $memberid=$memberi->memberid;

      $nmd = [

        'mobileno' => $memberid,
        'smsmsg' => $msg,
        'mailmsg' => '0',
        'callnotes' => '0',
      ];

      $msg = urlencode($msg);

      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

      if ($smssetting) {
       
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);
 
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg2;
          $action->smsrequestid = $otpsend;
          $action->subject = 'New MemberShip';
          $action->save();

           # code...
      }

       $emailsetting =  Emailsetting::where('status',1)->first();

       if ($emailsetting) { 

        $data = [
                             //'data' => 'Rohit',
               'msg' => $msg2,
               'mail'=> $mem->email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                $message->from($data['senderemail'], 'Member Message');
                $message->to($data['mail']);
                $message->subject($data['subject']);

          });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msg2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Member Mail';
          $action->save();

      }

      // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get(); 



      $msgformemberpin =  DB::table('messages')->where('messagesid','16')->get()->first();
      $msgformemberpin =$msgformemberpin->message;
      $msgformemberpin = str_replace("[firstname]",$fname,$msgformemberpin);
      $msgformemberpin= str_replace("[lastname]",$lname,$msgformemberpin);
      $msgformemberpin= str_replace("[pin]",$mpin,$msgformemberpin);
      $msgformemberpin2=$msgformemberpin;
      $msgformemberpin = urlencode($msgformemberpin);

      $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();

      if ($smssetting) {
      
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msgformemberpin, $url);
 
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msgformemberpin2;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Send FitPin';
          $action->save();

            # code...
      }

  if ($emailsetting) {

      $data = [
                             //'data' => 'Rohit',
               'msg' => $msgformemberpin2,
               'mail'=> $mem->email,
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                $message->from($data['senderemail'], 'Member Message For Pin');
                $message->to($data['mail']);
                $message->subject($data['subject']);

          });

          $action = new Emailnotificationdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->message = $msg2;
          $action->emailform = $data['senderemail'];
          $action->emailto = $data['mail'];
          $action->subject = $data['subject'];
          $action->messagefor = 'Member Mail For Set FitPin';
          $action->save();

      }


      // $msgformemberpinsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msgformemberpin.'&route=6')->get(); 

      // $nmdformemberpin = [

      //   'mobileno' => $mobileno,
      //   'smsmsg' => $msgformemberpin2,
      //   'mailmsg' => '0',
      //   'callnotes' => '0',
      // ];
      // DB::table('notoficationmsgdetails')->insert($nmdformemberpin);

      $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
      $RootScheme = RootScheme::get()->all();
       $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
      $PaymentTypes = PaymentType::get()->all();
      $receiptNo = '';
      $receipt = Payment::latest()->first();

      if($receipt==null){
        $receiptNo = '1';
      }
      else{
        $receiptNo = $receipt->receiptno+1;
      }
      $usermember=Member::leftJoin('users','member.userid','=','users.userid')->where('member.status',1)->where('member.mobileno',$mobileno)->get()->first();
      $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
      $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

      $sgst = (int)$sgst;
      $cgst = (int)$cgst;
      $tax =  $sgst + $cgst;

      $userid=$usermember->userid;

        DB::commit();
        $success = true;
    return redirect('assignPackageOrRenewalPackage/'.$userid)->with('users');

    } catch (\Exception $e) {
  // ************cache code*************************
        $success = false;
        DB::rollback();

    }
  /*************if try code fails**************************/
    if ($success == false) { 
      return redirect('dashboard');
    }

    /************************END *commit rollback****************************************/
  /*******************************************************************/
 

/****************************************************************/

 

// return view('admin.AssignPackage',compact('usermember','users','PaymentTypes','exerciseprogram','RootScheme','receiptNo','tax'));



}
    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
    $RootScheme = RootScheme::get()->all();
     $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->where('member.status',1)->get()->all();
     $memberdata='';
    $PaymentTypes = PaymentType::get()->all();
    $company = Company::get()->all();
    if($request->route('id')){
      $id=$request->route('id');
      $memberdata=MemberData::where('memberid',$id)->get()->first();
    }
    return view('admin.addMember',compact('exerciseprogram','RootScheme','users','PaymentTypes','company','memberdata'));
}


public function otpresendverify($mobileno){

 $mobileno = $mobileno;
 $user = User::where('mobileno',$mobileno)->get()->first();
 $email = $user->email;


 $rndno=rand(1000, 999999);

 $otpgenerate = [ 
  'mobileno'      => $mobileno,
  'email'         => $email,
  'code'          => $rndno,  
  'isexpired'    =>'0',            
  'created_at'     => date('Y-m-d  H:i:s'),
  'updated_at'     => date('Y-m-d  H:i:s'), 
];

DB::table('otpverify')->insert($otpgenerate);

    $msg=   DB::table('messages')->where('messagesid','18')->get()->first();
        
   
                  $msg =$msg->message;         
                  $msg= str_replace("[otp]",$rndno,$msg);                 

          $msg = urlencode($msg);

           $smssetting = Smssetting::where('status',1)->first();
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);
 
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Member ReSend Otp';
          $action->save();

// $your = "Your";
// $is = "is:".$rndno;
// $fit = "FITNESS5";
// $otp="OTP";

// $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$your.'+'.$fit.'+'.$otp.'+'.$is.'&route=6')->get(); 

return view('admin.verify')->with('mobileno',$mobileno)->with('message',''); 
} 
public function postverify(Request $request){

  $code = $request['otp'];
        // dd($request->MobileNo);

  $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->where('created_at', '>', 
    Carbon::now()->subMinute(30)->toDateTimeString())->first();

  $mobileno =$request->MobileNo;

  if($q){
    $q->isexpired = 1;
    $q->save();
    if($q){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Registered');
        </SCRIPT>");

      $r = "<script>document.write(p);</script>";
      
      $mem = Member::where('mobileno',$mobileno)->get()->first();
      $fname=$mem->firstname;
      $lname=$mem->lastname;
      $msg=   DB::table('messages')->where('messagesid','2')->get()->first();


      $msg =$msg->message;

      $msg = str_replace("[FirstName]",$fname,$msg);
      $msg= str_replace("[LastName]",$lname,$msg);

      $memberi= DB::table('member')->select('memberid')->get()->last();
      $memberid=$memberi->memberid;



      $nmd = [

        'mobileno' => $memberid,
        'smsmsg' => $msg,
        'mailmsg' => '0',
        'callnotes' => '0',
      ];

      $msg = urlencode($msg);

           $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
           if ($smssetting) {
            
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);
 
          $otpsend = Curl::to($url)->get();

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Member Otp Send';
          $action->save();
        }

      // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get(); 

      // DB::table('notoficationmsgdetails')->insert($nmd);



    }



    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
    $RootScheme = RootScheme::get()->all();
     $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
    $PaymentTypes = PaymentType::get()->all();
    $receiptNo = '';
    $receipt = Payment::latest()->first();

    if($receipt==null){
      $receiptNo = '1';
    }
    else{
      $receiptNo = $receipt->receiptno+1;

    }
    $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
    $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

    $sgst = (int)$sgst;
    $cgst = (int)$cgst;
    $tax =  $sgst + $cgst;
    $usermember=Member::leftJoin('users','member.userid','=','users.userid')->where('member.mobileno',$request->MobileNo)->get()->first();
    return view('admin.AssignPackage',compact('usermember','users','PaymentTypes','exerciseprogram','RootScheme','receiptNo','tax'));
    

  }
  else{
    return view('admin.verify')->with('mobileno',$request->MobileNo)->with('message','Please, try again');
  }

}

// public function create(Request $request)
// {

//   $method = $request->method();
//   if ($request->isMethod('post'))
//   {

//     $username=$request->get('username');

//     $usr = User::where('username', $request['username'])->orWhere('MobileNo',$request['CellPhoneNumber'])->get()->all();

//     if($usr){

//       return redirect()->back()->with('message','User Already exists');
//     }


//       $mobileno=$request->get('CellPhoneNumber');
//     $password=$username;
//     if(Inquiry::where('Cell',$mobileno)->get()->first()){
//      $closeinquiry=Inquiry::where('Cell',$mobileno)->get()->first();
//      $closeinquiry->Status = '3';
//      $closeinquiry->Reason = 'ConvertedIntoMember';
//      $closeinquiry->save(); 
//     }
//     $row1=User::create([
//       'username'=> $username,
//       'MobileNo'=> $mobileno,
//       'password'=>$password,  
//       'email'=>$request['email'],
//     ]);


//     $usermember =  Member::create([
//       'userid' => $row1->id,
//       'Created_date' =>  $request['Created_date'],
//       'lastname' => $request['lastname'],
//       'firstname' => $request['firstname'],
//       'gender' => $request['gender'],
//       'add' => $request['Address'],
//       'city' => $request['City'],
//       'email' => $request['email'],
//       'HearAbout' => $request['hearabout'],
//       'FormNo' => $request['FormNo'],
//       'HomePhoneNumber' => $request['HomePhoneNumber'],
//       'CellPhoneNumber' => $request['CellPhoneNumber'],
//       'OfficePhoneNumber' => $request['OfficePhoneNumber'],
//       'Profession' => $request['profession'],
//       'Birthday' => $request['birthday'],
//       'Anniversary' => $request['anniversary'],
//       'EmergancyName' => $request['emergancyname'],
//       'EmergancyRelation' => $request['emergancyrelation'],
//       'EmergancyAddress' => $request['emergancyaddress'],
//       'EmergancyPhoneNumber' => $request['EmergancyPhoneNumber'],
//       'working_hour_from' => $request['working_hour_from_1'],
//       'working_hour_to' => $request['working_hour_to_1'],
//       'Company_id' => $request['bycompany'],
//       // 'status' => $request['status'], 
//       // 'amount' => $request['amount'],

//     ]);

//     $MemberId = $usermember->id;
//      $this->validate($request, [

//             // 'attachments' => 'required',

//             'attachments.*' => 'mimes:doc,pdf,docx,png,jpg,jpeg|max:1024'

//     ]);

//     if($request->hasfile('attachments'))
//      {
//         foreach($request->file('attachments') as $file)
//         {
//             $name=$file->getClientOriginalName();
//             $file->move(public_path().'/files/', $name);  
//             $data[] = $name;  
//         }

//      $file = new Files();
//      $file->filename=json_encode($data);
//      $file->Member_id = $MemberId;
//      $file->save();
//      }



//     $fitnessgoals =  $request->get('fitnessgoals');
//     $fitnessgoal = DB::getSchemaBuilder()->getColumnListing('fitnessgoals');
//     $i=0;
//     $n0=0;
//     $n0=count($fitnessgoal);

//     Fitnessgoals::create([
//       'MemberId' => $usermember->id,
//       'OtherHelp'=> $request['OtherHelp'],
//       'SpecificGoalsa'=> $request['SpecificGoalsa'],
//       'SpecificGoalsb'=> $request['SpecificGoalsb'],
//       'SpecificGoalsc'=> $request['SpecificGoalsc'],
//     ]);

// // }
//     if($fitnessgoals!=null){
//       $fg1 = Fitnessgoals::first()->getFillable();
//       $fg = Fitnessgoals::where('MemberId', $MemberId)->first();
//       $n=0;
//       $n=count($fitnessgoals);

//       $n1=0;
//       $n1 = count($fg1);

//       for($i=0; $i<=$n1-2; $i++){
//         for($j=0;$j<$n;$j++){
//           if($fitnessgoals[$j] == $i){
//             $col= $fg1[$i];
//             $fg->$col = "1";
//             }
//           }
//         }
//       $fg->save();
//     }
// // *****************************************************  

//     $exerciseprograms =  $request->get('exerciseprograms');

//     $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprograms');
//     $i=0;
//     $n0=0;
//     $n0=count($exerciseprogram);

//     ExerciseProgram::create([
//       'MemberId' => $MemberId,
//       'OtherActivity'=> $request['OtherActivity'],
//       'OftenWeekExercise' =>  $request['OftenWeekExercise'],
//     ]);

//     if($exerciseprograms!=null){
//       $ep1 = ExerciseProgram::get()->first()->getFillable();
//       $ep = ExerciseProgram::where('MemberId', $MemberId)->first();
//       $n=0;
//       $n = count($exerciseprograms);
//       $n1=0;
//       $n1 = count($ep1);

//       for($i=0; $i<=$n1-2; $i++){
//         for($j=0;$j<$n;$j++){
//           if($exerciseprograms[$j] == $i){
//           $col = $ep1[$i];
//           $ep->$col = "1";
//           }
//         }
//       }
//       $rank=$request['rank'];
//       $goal=$request['goal'];
//       if($rank=="h1")
//       {
//        $rh=1;
//       }
//       else
//       {
//         $rh=0;
//       }
//       if($rank=="m1")
//       {
//         $rm=1;
//       }
//       else
//       {
//         $rm=0;
//       }
//       if($rank=="l1")
//       {
//         $rl=1;
//       }
//       else
//       {
//         $rl=0;
//       }
//       if($goal=="v1")
//       {
//        $gv=1;
//       }
//       else
//       {
//        $gv=0;
//       }
//       if($goal=="s1")
//       {
//         $gs=1;
//       }
//       else
//       {
//         $gs=0;
//       }
//       if($goal=="b1")
//       {
//         $gb=1;
//       }
//       else
//       {
//         $gb=0;
//       }

//       $ep->HighPriority=$rh;
//       $ep->MediumPriority=$rm;
//       $ep->LowPriority=$rl;

//       $ep->Very=$gv;
//       $ep->Semi=$gs;
//       $ep->Barely=$gb;

//       $ep->save();
// }

//       $user=$row1;
//       $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
//       $RootScheme = RootScheme::get()->all();
//       $users = User::get()->all();
//       $PaymentTypes = PaymentType::get()->all();
//       $receiptNo = '';
// $receipt = Payment::latest()->first();

// if($receipt==null){
//   $receiptNo = '1';
// }
// else{
//   $receiptNo = $receipt->ReceiptNo+1;

// }
//       return view('admin.AssignPackage',compact('usermember','user','users','PaymentTypes','exerciseprogram','RootScheme','receiptNo'));


// }

// $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
// $RootScheme = RootScheme::get()->all();
// $users = User::get()->all();
// $PaymentTypes = PaymentType::get()->all();
// $company = Company::get()->all();
// return view('admin.addMember',compact('exerciseprogram','RootScheme','users','PaymentTypes','company'));

// }

public function schemeActualPrice(Request $request)
{
  $id=$request->get('name');
  $row=DB::table('schemes')->select('schemeid','schemename','actualprice','baseprice','numberofdays')->where('schemeid','=',$id)->get();

  echo json_encode($row);
}

// public function createPayment(Request $request)
// {   

//    $loginuser = Session::get('username');
//   $method = $request->method();

//   if ($request->isMethod('post')){

//      $request->validate([
//       'SchemeID' => 'required',
//     ]);

//     $id= $request['selectusername'];
//     $memberfortimimg = Member::where('memberid',$id)->get()->first();
    
//     $mfrom =  date("H:i", strtotime($memberfortimimg->workinghourfrom));
//     $mto =  date("H:i", strtotime($memberfortimimg->workinghourto));
//     $userid=$memberfortimimg->userid;

//     $scheme='';
//     $scheme= Scheme::where('schemeid',$request->SchemeID)->get()->first();
//     if($scheme){

//      $sfrom =  date("H:i", strtotime($scheme->workinghourfrom));
//      $sto =  date("H:i", strtotime($scheme->workinghourto));


//        if(!($sfrom <= $mfrom &&  $sto >= $mto)){
//   // echo 'no'.$sfrom.$mfrom.$sto.$mto;
//         // dd('sdfsdf');
      
//        return redirect('memberProfile/'.$id)->with('message', 'Your timing is different from  package timimg');
//       }
//     }
//     $pay=Payment::where('userid',$userid)->get()->last();

//     if($pay){
//     if($pay->remainingamount){

//     $payment= Payment::where('userid',$userid)->get()->all();
//     $member = DB::table('member')->select('member.memberid AS mid','member.*','users.*','schemes.*','fitnessgoals.*','exerciseprogram.*')
//     ->leftJoin('users','member.userid','=','users.userid')
//     ->leftJoin('schemes', 'schemes.schemeid', '=', 'users.userid')
//     ->leftJoin('fitnessgoals','member.memberid','=','fitnessgoals.memberid')
//     ->leftJoin('exerciseprogram','member.memberid','=','exerciseprogram.memberid')
//     ->where('member.userid','=',$userid)
//     ->get()->first();

//     $packages = MemberPackages::with('Scheme')->where('userid',$member->userid)->get()->all();

//     $memberid = Member::where('userid',$userid)->get()->first();
//     $memberId=$memberid->memberid;
//     $mobileno =$memberid->mobileno; 
//     $pay = MemberPackages::leftJoin('payments','payments.receiptno','=','memberpackages.memberpackagesid')->where('memberpackages.userid',$userid)->get()->all();
//     $t= array();
//     foreach ($packages as $key => $value) {
//     $a =  Payment::where('userid',$userid)->where('schemeid',$value->schemeid)->where('receiptno',$value->memberpackagesid)->latest()->first();
//     array_push($t,$a);
//     }

//     $images =  DB::table('files')->where('memberid', $memberid->memberid)->pluck('filename')->first();
//     $img='';
//     if($images){
//     $img=json_decode($images);
//     }else{
//     $img='';
//     }
//     $company = Company::get()->all();
//     $notes=Notes::where('userid',$userid)->get()->all();


//     $activities = MemberPackages::where('created_at','<', Carbon::now()->subHours(2)->toDateTimeString())->where('userid',$userid)->get()->all();
//     $notify = Notify::where('userid',$userid)->get()->all();

//     return redirect('memberProfile/'.$memberid->memberid)->with('member','packages','payment','img','company','notes','activities','notify','t')->with('message','Please Complete Your Payment');

//     }
//     }
//     if(Memberpackages::where('userid',$userid)->where('schemeid', $request['SchemeID'])){
//     $memberpack = Memberpackages::where('userid',$userid)->where('schemeid', $request['SchemeID'])->get()->all();

//     foreach($memberpack as $pack){

//     if(!( $request['Join_date'] > $pack->expiredate)){

//     return redirect()->back()->with('message','You Cant assign same package untill its not completed');
//     }

//     }
//     }


//     $member = User::findOrFail($userid);
//     $mem = Member::where('userid',$userid)->get()->first();
//     $mobileno=$mem->mobileno;
//     $MemberId=$mem->memberid;
//     $schemeid=$request['SchemeID'];
//     $schemeassigned=Scheme::where('schemeid',$schemeid)->get()->first();
//     $schemename=$schemeassigned->schemename;

//     if(MemberPackages::where('userid',$userid)->get()->all()){
//     $notify=Notify::create([
//     'userid'=> $userid,
//     'details'=> 'User has renewal of package',
//     ]);  

//     }
//     else{
//     $notify=Notify::create([
//     'userid'=> $userid,
//     'details'=> 'User has assign a package '.$schemename,
//     ]);  
//     }


//     $Memberpackages = Memberpackages::create([
//     'userid'=> $userid,
//     'schemeid'=> $request['SchemeID'],
//     'joindate'=> $request['Join_date'],
//     'status' => '1',
//     'expiredate'=> \Carbon\Carbon::parse($request['Expire_date'])->format('Y-m-d'),

//     ]);


//     // 
//     $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
//     $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

//     $sgst = (int)$sgst;
//     $cgst = (int)$cgst;
//     $tax =  $sgst + $cgst;

//     $mode= $request['Mode'];
//     $remark= $request['Remark'];
//     $amount= $request['Amount'];
//     $ActualAmount = 0;
//     $ReceiptNo = '';
//     $receipt = Payment::latest()->first();
//     if($receipt==null){
//     $ReceiptNo = '1';
//     }
//     elseif($request['ReceiptNo']){
//     $ReceiptNo = $request['ReceiptNo'];
//     }
//     else{
//     $ReceiptNo = $receipt->receiptno+1;

//     }
//     $ReceiptNo = (Payment::max('receiptno')+1);

//     if( $request->has('CashCredit')){
//     $payment =  PaymentDetails::create([
//     'ReceiptNo' =>  $ReceiptNo,   
//     'Amount' =>    $request['CashCredit'],
//     ]);
//     $member = Member::Where('userid',$id)->get()->first();
//     $member->amount -= $request['CashCredit'];
//     $member->save();

//     }

//     if(!$mode){
//     $mode = array();
//     array_push($mode, 'no mode');

//     $payment =  Payment::create([
//     'memberid' =>  $MemberId,      
//     'userid' => $userid,
//     'actualamount' =>  $request['ActualAmount'],
//     'amount' =>  $ActualAmount,
//     'tax' =>   $tax ,
//     'taxAmount' => $request['TaxAmount'],
//     'discount' => $request['Discount'],
//     'discountamount' => $request['DiscountAmount'],
//     'discount2' => $request['Discount2'],
//     'discount2amount' => $request['Discount2Amount'],
//     'date' => $request['Date'],
//     'paymentdate' => now(),
//     'mode' =>'no mode',
//     'schemeid' => $request['SchemeID'],
//     'otherchargesdetailsid' => $request['OtherChargesDetailsId'],
//     'expenseid' => $request['ExpenseId'],
//     'expensedetailsid' => $request['ExpenseDetailsId'],
//     'employeeid' => $request['EmployeeId'],
//     'voucherid' => $request['VoucherId'],
//     'billid' => $request['BillId'],
//     'storebillid' => $request['StoreBillId'],
//     'receiptno' => $ReceiptNo,
//     'employeesalaryid' => $request['EmployeeSalaryId'],
//     'type' => 'Debit',
//     'remarks' =>  'no mode',
//     'remainingamount'=> $request['rtotal'],
//     'duedate' => $request['duedate'],
//     'takenby'=>$loginuser,
//     ]);

//     $request['Mode']='no mode';
//     }
//     else{

//     for ($n=0; $n < count($mode) ; $n++) { 

//     $ActualAmount += $amount[$n];

//     $payment =  Payment::create([
//     'memberid' =>  $MemberId,      
//     'userid' => $userid,
//     'actualamount' =>  $request['ActualAmount'],
//     'amount' =>  $amount[$n],
//     'tax' =>   $tax ,
//     'taxamount' => $request['TaxAmount'],
//     'discount' => $request['Discount'],
//     'discountamount' => $request['TotalDiscount'],
//     'discount2' => $request['Discount2'],
//     'discount2amount' => $request['Discount2Amount'],
//     'date' => $request['Date'],
//     'paymentdate' => now(),
//     'mode' => PaymentType::find($request['Mode'][$n])->paymenttype,
//     'schemeid' => $request['SchemeID'],

//     'otherchargesdetailsid' => $request['OtherChargesDetailsId'],
//     'expenseid' => $request['ExpenseId'],
//     'expensedetailsid' => $request['ExpenseDetailsId'],
//     'employeeid' => $request['EmployeeId'],
//     'voucherid' => $request['VoucherId'],
//     'billid' => $request['BillId'],
//     'storebillid' => $request['StoreBillId'],
//     'receiptno' => $ReceiptNo,
//     'employeesalaryid' => $request['EmployeeSalaryId'],
//     'type' => 'Credit',
//     'remarks' =>  $remark[$n],
//     'remainingamount'=> $request['rtotal'],
//     'duedate' => $request['duedate'],
//     'takenby'=>$loginuser,

//     ]);
//     }

//     $payment =  Payment::create([
//     'memberid' =>  $MemberId,      
//     'userid' => $userid,
//     'actualamount' =>  $request['ActualAmount'],
//     'amount' =>  $ActualAmount,
//     'tax' =>   $tax ,
//     'taxamount' => $request['TaxAmount'],
//     'discount' => $request['Discount'],
//     'discountamount' => $request['DiscountAmount'],
//     'discount2' => $request['Discount2'],
//     'discount2amount' => $request['Discount2Amount'],
//     'date' => $request['Date'],
//     'paymentdate' => now(),
//     'mode' =>'-',
//     'schemeid' => $request['SchemeID'],
//     'otherchargesdetailsid' => $request['OtherChargesDetailsId'],
//     'expenseid' => $request['ExpenseId'],
//     'expensedetailsid' => $request['ExpenseDetailsId'],
//     'employeeid' => $request['EmployeeId'],
//     'voucherid' => $request['VoucherId'],
//     'billid' => $request['BillId'],
//     'storebillid' => $request['StoreBillId'],
//     'receiptno' => $ReceiptNo,
//     'employeesalaryid' => $request['EmployeeSalaryId'],
//     'type' => 'Debit',
//     'remarks' =>  '-',
//     'remainingamount'=> $request['rtotal'],
//     'duedate' => $request['duedate'],
//     'takenby'=>$loginuser,
//     ]);

//     }  


//     $mem = Member::where('mobileno',$mobileno)->get()->first();
//     $pack=Scheme::where('schemeid',$Memberpackages->schemeid)->get()->first();
//     $pack=$pack->schemename;
//     $fname=$mem->firstname;
//     $lname=$mem->lastname;

//     $fname=$fname . ' ' . $lname;
//     $id=$mem->memberid;
//     $userid=$mem->userid;
//     $joindate=$Memberpackages->joindate;

//     $joindate = date("d-m-Y", strtotime($joindate));
//     $enddate=$Memberpackages->expiredate;
//     $enddate= date("d-m-Y", strtotime($enddate));
//     $amnt=$payment->amount;
//     $InvoiceID=$payment->receiptno;
//     $TransactionType='Fully';
//     $duedate='';
//     $dueamnt='';
//     if($payment->duedate){
//     $duedate=$payment->duedate;
//     $duedate= date("d-m-Y", strtotime($duedate));
//     $dueamnt=$payment->remainingamount;
//     $TransactionType='Partially';
//     }

//     $msg=   DB::table('messages')->where('messagesid','13')->get()->first();


//     $msg =$msg->message;
//     $msg = str_replace("[Name of Member]",$fname,$msg);
//     $msg= str_replace("[ID]",$id,$msg);
//     $msg= str_replace("[Name of Packge]",$pack,$msg);
//     $msg= str_replace("[Fully/Partially]",$TransactionType,$msg);
//     $msg= str_replace("100",$amnt,$msg);
//     $msg= str_replace("[join date]",$joindate,$msg);
//     $msg= str_replace("[End Date]", $enddate,$msg);
//     $msg= str_replace("[InvoiceID]",$InvoiceID,$msg); 

//     $due='';
//     if($TransactionType == 'Partially'){
//     $due="Due Amount:[Due Amount] Next Due Date: [Due Date]";
//     $due= str_replace("[Due Amount]",$dueamnt,$due);
//     $due= str_replace("[Due Date]", $duedate,$due);

//     $msg=''.$msg.''.$due.'';
//     }
//     $memberi= DB::table('member')->select('memberid')->get()->last();
//     $memberid=$memberi->memberid;


//     $nmd = [

//     'mobileno' => $mobileno,
//     'smsmsg' => $msg,
//     'mailmsg' => '0',
//     'callnotes' => '0',
//     ];


//     $msg = urlencode($msg);
//     $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get(); 

//     DB::table('notoficationmsgdetails')->insert($nmd);




//     $notify=Notify::create([

//     'userid'=> $userid,
//     'details'=> 'User has Made a Payment of '.$payment->amount,
//     ]);

//     $summry = array("firstname"=>$fname, "joindate"=>$joindate,   
//     "enddate"=>$enddate, "amnt"=>$amnt,  "InvoiceID"=>$InvoiceID, "TransactionType"=>$TransactionType, "duedate"=>$duedate,  
//     "dueamnt"=>$dueamnt,"pack"=>$pack);


//     return view('admin.summry')->with('summry',$summry);

//     }
//     $sgst = AdminMaster::where('title','sgst')->pluck('description')->first();
//     $cgst = AdminMaster::where('title','cgst')->pluck('description')->first();

//     $sgst = (int)$sgst;
//     $cgst = (int)$cgst;
//     $tax =  $sgst + $cgst;

//     $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
//     $RootScheme = RootScheme::get()->all();
//      $users= DB::table('member')->join('users', 'member.userid', '=', 'users.userid')->get()->all();
//     $PaymentTypes = PaymentType::get()->all();
//      $ReceiptNo = (Payment::max('receiptno')+1);

// return view('admin.AssignPackage',compact('exerciseprogram','RootScheme','users','PaymentTypes','ReceiptNo','tax'));

// }


// public function edituser(Request $request)
// {
//  $id= $request->get('id');

//  $usered = User::find($id)->first();

//  $username=$request->get('username');
//       // echo $username;
//  $mobileno=$request->get('mobileno');
//  $password=$username.$mobileno;
//  $usered->username = $username;
//  $usered->MobileNo =  $mobileno;
//  $usered->password = $password;
//  $usered->save();

    
//  $userid=$usered->id;
//        // echo $userid;
// }

    public function editMember($id, Request $request)
    {
      $method = $request->method();
      $useredt=User::findOrFail($id);
   

      if ($request->isMethod('post'))
      {

         $request->validate([
          'CellPhoneNumber' => 'required|max:11|min:10',
          'lastname' => 'required|max:255',
          'firstname' => 'required',
          'gender' =>'required',
          'file' => 'mimes:jpeg,bmp,png|max:5000',
          'attachments.*' => 'mimes:jpeg,bmp,png|max:5000',
        ]);
        $user = User::where('usermobileno',$request->CellPhoneNumber)->where('userid','!=',$id)->get()->first();
          if($user){
            return redirect()->back()->withErrors(['User Mobile No already Exist']);
          }
          $member = Member::where('mobileno',$request->CellPhoneNumber)->where('userid','!=',$id)->get()->first();
          if($member){
            return redirect()->back()->withErrors(['Member Mobile No already Exist']);
          }
        /**********************COMMIT ROLLBACK IMP******************************************/
     
        /*************************try code**********************************************/
    
      DB::beginTransaction();
        try {

          $useredt=User::findOrFail($id);
          $memberedt=$useredt->Member;
          $oldmobileno =  $memberedt->mobileno;   

          $username=$request->get('username');
                    // echo $username;
          $mobileno=$request->get('CellPhoneNumber');
          $password=$username.$mobileno;
          $useredt->username = $request['username'];
          $useredt->usermobileno = $mobileno;
          $useredt->userpassword = $password;
          $useredt->save();
          // echo $useredt->userid;
             

          $memberedt->lastname = $request['lastname'];
          $memberedt->firstname = $request['firstname'];
          $memberedt->gender = $request['gender'];
          $memberedt->address= $request['Address'];
          $memberedt->city = $request['City'];
          $memberedt->email = $request['email'];
          $memberedt->hearabout = $request['HearAbout'];
          $memberedt->bloodgroup = $request['bloodgroup'];
          $memberedt->formno = $request['FormNo'];
          $memberedt->homephonenumber = $request['HomePhoneNumber'];
          $memberedt->mobileno = $request['CellPhoneNumber'];

          $memberedt->officephonenumber = $request['OfficePhoneNumber'];
          $memberedt->profession =$request['profession'];
          $memberedt->birthday =$request['birthday'];
          $memberedt->anniversary = $request['anniversary'];
          $memberedt->emergancyname = $request['emergancyname'];
          $memberedt->emergancyrelation = $request['emergancyrelation'];
          $memberedt->emergancyaddress = $request['emergancyaddress'];
          $memberedt->emergancyphonenumber = $request['EmergancyPhoneNumber'];
          $memberedt->workinghourfrom =  Carbon::parse($request['working_hour_from_1']);
          $memberedt->workinghourto =  Carbon::parse($request['working_hour_to_1']);
          $memberedt->companyid = $request['bycompany'];

          $memberedt->save();

          $notification=Notification::where('mobileno',$oldmobileno)->get()->first();
          $notification->mobileno = $request['CellPhoneNumber'];
          $notification->save();

          $fitnessgoals = Fitnessgoals::where('memberid',$memberedt->memberid)->get()->first();

          $fitnessgoals->delete();
          $fitnessgoals =  $request->get('fitnessgoals');

          $fitnessgoal = DB::getSchemaBuilder()->getColumnListing('fitnessgoals');
          $i=0;
          $n0=count($fitnessgoal);


          Fitnessgoals::create([
            'memberid' => $memberedt->memberid,
            'otherhelp'=> $request['OtherHelp'],
            'specificgoalsa'=> $request['SpecificGoalsa'],
            'specificgoalsb'=> $request['SpecificGoalsb'],
            'specificgoalsc'=> $request['SpecificGoalsc'],

          ]);

          if($fitnessgoals!=null){
            $fg1 = Fitnessgoals::where('memberid', $memberedt->memberid)->first()->getFillable();
            $fg = Fitnessgoals::where('memberid', $memberedt->memberid)->first();
            $n = count($fitnessgoals);
            $n1 = count($fg1);
          


            for($i=0; $i<=$n1-2; $i++){
              for($j=0;$j<$n;$j++){

                if($fitnessgoals[$j] == $i){

                  $col= $fg1[$i];
                  $fg->$col = "1";
                }

              }
            }
            $fg->save();
          }


          $exerciseprograms = ExerciseProgram::where('memberid',$memberedt->memberid)->get()->first();
          if($exerciseprograms){
            $exerciseprograms->delete();
          }
          
          $exerciseprograms = $request->get('exerciseprograms');
          $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
          // dd($exerciseprogram);
          $i=0;
          $n0=count($exerciseprogram);

          ExerciseProgram::create([
            'memberid' => $memberedt->memberid,
            'otheractivity'=> $request['OtherActivity'],
            'oftenweekexercise' =>  $request['OftenWeekExercise'],
          ]);
          if($exerciseprograms!=null){
           $ep1 = ExerciseProgram::get()->first()->getFillable();
            // dd($ep1);
           $ep = ExerciseProgram::where('memberid', $memberedt->memberid)->first();
           $n=0;
           $n = count($exerciseprograms);
           $n1=0;
           $n1 = count($ep1);
   
           for($i=0; $i<=$n1-1; $i++){
            for($j=0;$j<$n;$j++){

              if($exerciseprograms[$j] == $i){

               $col = $ep1[$i];
               $ep->$col = "1";

              }
            }
           }
            $rank=$request['rank'];
            $goal=$request['goal'];

            if($rank=="h1")
            {
              $rh=1;
            }else{
              $rh=0;
            }
            if($rank=="m1")
            {
              $rm=1;
            } else {
            $rm=0;
            }
            if($rank=="l1")
            {
            $rl=1;
            }else
            {
            $rl=0;
            }
            if($goal=="v1")
            {
             $gv=1;
            }else{
              $gv=0;
            }
            if($goal=="s1")
            {
             $gs=1;
            } else {
              $gs=0;
            }
            if($goal=="b1")
            {
             $gb=1;
            }else{
              $gb=0;
            }

            $ep->highpriority=$rh;
            $ep->mediumpriority=$rm;
            $ep->lowpriority=$rl;

            $ep->very=$gv;
            $ep->semi=$gs;
            $ep->barely=$gb;

            $ep->save();
          }
          $photo=''; 

          if($file = $request->file('file')){

           $file_name = $file->getClientOriginalName();
           $file_size = $file->getClientSize();
           $file->move(public_path().'/files/', $file_name);

           $photo = $file_name;
           $memberedt->photo= $photo;
           $memberedt->save();
          }
          if($request->base64image){
            $data = Input::all();
            $png_url = "perfil-".time().".jpg";
            $path = public_path() . "/files/" . $png_url;
            $img = $data['base64image'];
            $img = substr($img, strpos($img, ",")+1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);
            $file_name=$png_url;
            $photo = $file_name;
            $memberedt->photo= $photo;
            $memberedt->save();

          }
          if($request->hasfile('attachments'))
          {
            foreach($request->file('attachments') as $file)
              { 
              $name=$file->getClientOriginalName();
              $name= $name.'_'.$request['username'];
              $file->move(public_path().'/files/', $name);  
              $data[] =$request['allfiles'];
              }
            if(Files::where('memberid',$memberedt->memberid)->get()->first())  {
                $file = Files::where('memberid',$memberedt->memberid)->get()->first();
                $file->filename=$request['allfiles'];
                $file->memberid = $memberedt->memberid;
                $file->save();
            }
            else{
             $file = new Files();
             $file->filename=$request['allfiles'];
             $file->memberid = $memberedt->memberid;
             $file->save();
           }
          }

       DB::commit();
        $success = true;
            return redirect()->back()->with('message' ,'Member Successfully Updated');

        /***********************End **try code**********************************************/
      }
         catch (\Exception $e) {
          /*************cache code**************************/
                $success = false;
                DB::rollback();

            }
          /*************if try code fails**************************/
            if ($success == false) { 
              return redirect('dashboard');
            }

      }

    }

}





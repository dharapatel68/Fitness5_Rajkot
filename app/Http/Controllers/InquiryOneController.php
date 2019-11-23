<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inquiry;
use App\Followup;
use App\Reason;
use DB;
use Carbon\Carbon;
use App\RootScheme;
use App\User;
use App\PaymentType;
use App\Company;
use Ixudra\Curl\Facades\Curl;
use App\OTPVerify;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;
use App\Emailnotificationdetails;
use App\Smssetting;
use App\Notificationmsgdetails;
use App\Notification;



class InquiryOneController extends Controller
{
  public function index(Request $request)
  {

       if($request->isMethod('post'))
       {

             $fdate = $request->get('inquirydatefrom');
             $tdate = $request->get('inquirydateto');
              $hearabout = $request->get('hearabout');
              $rating=$request->get('rating');
              $firstname=$request->get('firstname');

              $mobileno=$request->get('mobileno');

             $ffromdate = $request->get('followupdatefrom');
             $ftodate = $request->get('followupdateto'); 
             $smsmale = '';
             $smsfemale = '';
             $query=[];
             $query['fdate']=$fdate ;
             $query['tdate']=$tdate ;
             $query['hearabout']=$hearabout;
              $query['rating']=$rating;
              $query['firstname']=$firstname;
              $query['mobileno']=$mobileno;
                $query['ffromdate']=$ffromdate;
              $query['ftodate']=$ftodate;
              
           $inquiry=  Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->select(['followup.status as fstatus','followup.*','inquiries.*']);
    
        // dd($request->input('rating'));
         if ($firstname != "") {
                    $inquiry->where('inquiries.inquiriesid',$firstname);
       }
        if ($mobileno != "") {
                    $inquiry->where('inquiries.inquiriesid',$mobileno);
       } 
       if ($fdate != "") {
                   $from = date($fdate);
                   //$to = date($to);
                   if (!empty($tdate)) {
                       $to = date($tdate);
                   }else{
                       $to = date('Y-m-d');
                   }
                   // ->whereBetween('followupdays', [$from, $to])
                   $inquiry->whereBetween('followup.followupdays',[$from,$to])->get()->all();
                 
       }
       if ($tdate != "") {
                   $to = date($tdate);
                   if (!empty($fdate)) {
                       $from = date($fdate);
                   }else{
                       $from = date('Y-m-d');
                   }
                    $inquiry->whereBetween('followup.followupdays',[$from,$to]);
       }
       if ($hearabout != "") {
                    $inquiry->where('inquiries.hearabout',$hearabout);
       }
        if($rating)
        {
                $inquiry->where('inquiries.rating', '=',$rating);
        }
      
       if ($ffromdate != "") 
       {
                   $from = date($ffromdate);
                   //$to = date($to);
                   if (!empty($ftodate)) {
                       $to = date($ftodate);
                   }else{
                       $to = date('Y-m-d');
                   }
                   // ->whereBetween('followupdays', [$from, $to])
                   $inquiry->whereBetween('followup.followupdays',[$from,$to])->get()->all();
                 
       }
       if ($ftodate != "") {
                   $to = date($ftodate);
                   if (!empty($ffromdate)) {
                       $from = date($ftodate);
                   }else{
                       $from = date('Y-m-d');
                   }
                    $inquiry->whereBetween('followup.followupdays',[$from,$to]);
       }
      
        $members = $inquiry->orderBy('inquiriesid','desc')->paginate(8)->appends('query');

         $users = Inquiry::where('status','1')->get()->all();
       return view('admin.viewinquiry',compact('members','users','query'));
      }
       $users = Inquiry::where('status','1')->get()->all();

    $followid=array();
    $members=array();
    for($i=0;$i<count($users);$i++) {
      $inquiryid = $users[$i]['inquiriesid'];

      $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');
         
      if($x!='')
        $followid[] =  $x;
    }

    
    $members = DB::select(DB::raw("SELECT inquiries.*, subquery1.max_id, (select calldate as calldate from followupcalldetails where followupcalldetails.followupcalldetailsid = subquery1.max_id) as calldate
      FROM inquiries  LEFT JOIN
      (SELECT inquiriesid, MAX(inquiriesid) AS max_id
      FROM followupcalldetails
      GROUP BY inquiriesid ) subquery1 ON 
      subquery1.inquiriesid = inquiries.inquiriesid  where inquiries.status = 1 ORDER BY inquiries.inquiriesid DESC "));
     $currentPage = LengthAwarePaginator::resolveCurrentPage();
  $itemCollection = collect($members);
   $perPage = 10;
    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
      $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
       $paginatedItems->setPath($request->url());
         return view('admin.viewinquiry')->with(['members' => $paginatedItems ,'users' =>$users]);


  }
//   public function index2(Request $request)
//   {

//     if($request->isMethod('post'))
//     {
//       if($request->get('firstname')!="")
//       {
//         $firstname=$request->get('firstname');
//         $firstname_select=$request->get('firstname');
//             //$members = Inquiry::where('inquiriesid','=',$firstname)->where('status','1')->get();
//         $users = Inquiry::where('status','1')->get()->all();

//         $followid=array();
//         for($i=0;$i<count($users);$i++) {
//           $inquiryid = $users[$i]['inquiriesid'];

//           $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');

//           if($x!='')
//             $followid[] =  $x;

//         }

//         $members = DB::select( DB::raw("select  inquiries.*,followupcalldetails.*  from  `inquiries` left Join followupcalldetails on followupcalldetails.inquiriesid = inquiries.inquiriesid AND followupcalldetails.followupcalldetailsid IN(".implode(',', $followid).") where inquiries.inquiriesid=$firstname"));

//           $currentPage = LengthAwarePaginator::resolveCurrentPage();
//           $itemCollection = collect($members);
//           $perPage = 10;
//           $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
//           $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
//           $paginatedItems->setPath($request->url());

//            return view('admin.viewinquiry')->with(['members' => $paginatedItems ,'users' =>$users,'firstname_select'=> $firstname_select]);

//        // return view('admin.viewinquiry',compact('members','users', 'firstname_select'));
//       }
//       if($request->get('mobileno')!="")
//       {
//         $mobileno=$request->get('mobileno');
//           //$members = Inquiry::where('inquiriesid','=',$mobileno)->where('status','1')->get();
//         $users = Inquiry::where('status','1')->get()->all();
//         $users = Inquiry::where('status','1')->get()->all();

//         $followid=array();
//         for($i=0;$i<count($users);$i++) {
//           $inquiryid = $users[$i]['inquiriesid'];

//           $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');

//           if($x!='')
//             $followid[] =  $x;

//         }

//         $members = DB::select( DB::raw("select  inquiries.*,followupcalldetails.*  from  `inquiries` left Join followupcalldetails on followupcalldetails.inquiriesid = inquiries.inquiriesid AND followupcalldetails.followupcalldetailsid IN(".implode(',', $followid).") where inquiries.inquiriesid=$mobileno"));

//           $currentPage = LengthAwarePaginator::resolveCurrentPage();
//           $itemCollection = collect($members);
//           $perPage = 10;
//           $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
//           $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
//           $paginatedItems->setPath($request->url());

//           return view('admin.viewinquiry')->with(['members' => $paginatedItems ,'users' =>$users,'mobileno'=>$mobileno]);
//         //return view('admin.viewinquiry',compact('members','users', 'mobileno'));
//       }
//       elseif($request->get('inquirydatefrom')!="")
//       {

//         $inquirydatefrom=$request->get('inquirydatefrom');
//         $inquirydateto=$request->get('inquirydateto');

//         if(empty($inquirydateto)){
//           $inquiryto = date('Y-m-d');
//         } else {
//           $inquiryto = $inquirydateto;
//         }
        
//         $members = Inquiry::whereBetween('createddate', [$inquirydatefrom, $inquiryto])->where('status','1')->paginate(10);
//         $users = Inquiry::where('status','1')->get()->all();
//         return view('admin.viewinquiry',compact('members','users','inquirydatefrom', 'inquirydateto'));  
//       }
//       elseif($request->get('inquirydateto')!="")
//       {

//         $inquirydatefrom=$request->get('inquirydatefrom');
//         $inquirydateto=$request->get('inquirydateto');

//         if(empty($inquirydatefrom)){
//           $inquiryfrom = date('Y-m-d');
//         } else {
//           $inquiryfrom = $inquirydatefrom;
//         }
        
//         $members = Inquiry::whereBetween('createddate', [$inquiryfrom, $inquirydateto])->where('status','1')->paginate(10);
//         $users = Inquiry::where('status','1')->get()->all();
//         return view('admin.viewinquiry',compact('members','users','inquirydatefrom', 'inquirydateto'));  
//       }
//       elseif($request->get('quality')!="")
//       {
//         $quality=$request->get('quality');
//         $members = Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status','1')->where('inquiries.rating', $quality)->paginate(10);
//         $users = Inquiry::where('status','1')->get()->all();
//         if (count ($members ) > 0){
//           return view('admin.viewinquiry',compact('members','users', 'quality'));
//         }else{
//           $members='';
//           return view('admin.viewinquiry',compact('users','members', 'quality'));
//         }
//       }
//       elseif($request->get('rating')!="")
//       {

//         $rating=$request->get('rating');
//         $members = Inquiry::where('rating',$rating)->where('status','1')->paginate(10);
//         $users = Inquiry::where('status','1')->get()->all();
//         return view('admin.viewinquiry',compact('members','users'));  
//       }
//       elseif($request->get('followupdatefrom')!="")
//       {

//        $followupdatefrom=$request->get('followupdatefrom');
//        $followupdateto=$request->get('followupdateto');

//        if(empty($followupdateto)){
//         $followupto = date('Y-m-d');
//        } else {
//         $followupto = $followupdateto;
//        }

//        $members = Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status','1')->whereBetween('followup.followuptakendate',[$followupdatefrom, $followupto])->paginate(10);

//        $users = Inquiry::where('status','1')->get()->all();

//        return view('admin.viewinquiry',compact('members','users','followupdatefrom','followupdateto'));  
//       }
//       elseif($request->get('followupdateto')!="")
//       {

//        $followupdatefrom=$request->get('followupdatefrom');
//        $followupdateto=$request->get('followupdateto');

//       if(empty($followupdateto)){
//         $followupfrom = date('Y-m-d');
//       } else {
//         $followupfrom = $followupdatefrom;
//        }

//        $members = Inquiry::leftJoin('followup','followup.inquiryid','=','inquiries.inquiriesid')->where('inquiries.status','1')->whereBetween('followup.followuptakendate',[$followupfrom,$followupdateto])->paginate(10);

//        $users = Inquiry::where('status','1')->get()->all();

//        return view('admin.viewinquiry',compact('members','users','followupdatefrom','followupdateto'));  
//       }
//       elseif($request->get('HearAbout')!="")
//       {
//         $hearabout=$request->get('HearAbout');
//         $members = Inquiry::where('hearabout',$hearabout)->paginate(10);
//         $users = Inquiry::get()->all();
//         return view('admin.viewinquiry',compact('members','users','hearabout'));  
//       }
//       else
//       {
//       $members =Inquiry::where('status','1')->get()->all();
//         $users = Inquiry::where('status','1')->get()->all();        

//         return view('admin.viewinquiry',compact('members','users'));
//       }
//     }

//     $users = Inquiry::where('status','1')->get()->all();

//     $followid=array();
//     $members=array();
//     for($i=0;$i<count($users);$i++) {
//       $inquiryid = $users[$i]['inquiriesid'];

//       $x= DB::table('followupcalldetails')->where('inquiriesid',$inquiryid)->MAX('followupcalldetailsid');
         
//       if($x!='')
//         $followid[] =  $x;
//     }

    
//     $members = DB::select(DB::raw("SELECT inquiries.*, subquery1.max_id, (select calldate as calldate from followupcalldetails where followupcalldetails.followupcalldetailsid = subquery1.max_id) as calldate
//       FROM inquiries  LEFT JOIN
//       (SELECT inquiriesid, MAX(inquiriesid) AS max_id
//       FROM followupcalldetails
//       GROUP BY inquiriesid ) subquery1 ON 
//       subquery1.inquiriesid = inquiries.inquiriesid where inquiries.status = 1
//      "));
//      $currentPage = LengthAwarePaginator::resolveCurrentPage();
//   $itemCollection = collect($members);
//    $perPage = 10;
//     $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
//       $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
//        $paginatedItems->setPath($request->url());
//     // $members->paginate(8);
   
// // return view('items_view', ['items' => $paginatedItems]);

//     return view('admin.viewinquiry')->with(['members' => $paginatedItems ,'users' =>$users]);
//   }

  public function closeinquiry($id, Request $request)
  { 

    $method = $request->method();

    if ($request->isMethod('post'))
    {     

      $inquiry=Inquiry::findOrFail($id);

      $inquiry->status = '0';
      $inquiry->reason = $request['reason'];
               //$inquiry->reasondescription = $request['description'];

      $inquiry->save();
      if(Followup::where('inquiryid',$id)->get()->first()){
        $followup=Followup::where('inquiryid',$id)->get()->first();

        $followup->status = '4';
        $followup->reason = 'Close Inquiry';
        $followup->save();
    }

      return redirect('inquiry')->with('message', 'inquiry is closed');
    }

    $Reasons = Reason::get(['reasonid','reason'])->all();

    return view('admin.closeinquiry',compact('Reasons','id'));
  }

  public function confirminquiry($id)
  { 

    $inquiry=Inquiry::findOrFail($id);

    $inquiry->status = '2';
    $inquiry->save();

    if(Followup::where('inquiryid',$id)->get()->first()){
      $followup=Followup::where('inquiryid',$id)->get()->first();

      $followup->status = '3';
      $followup->reason = 'Confirm Inquiry';
      $followup->save();
    }

    $users = Inquiry::where('status','1')->get()->all();
    $members = Inquiry::where('status','1')->get()->all();

                // return view('admin.viewinquiry',compact('users','members'));
    return redirect('viewconfirmedinquiry');
  }

  public function editinquiry($id,Request $request) 
  {
    $method = $request->method();
    $f=Inquiry::findOrFail($id);
    $fd = Followup::where('inquiryid',$id)->first();

    if($request->isMethod('post')){

      $v = $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'gender' => 'required',
        'email' => 'required|email',
        'mobileno' =>'required|max:10',
      ]);


     $f->firstname=$request->input('firstname');
     $f->lastname=$request->input('lastname');
     $f->gender=$request->input('gender');
     $f->email=$request->input('email');
     $f->mobileno=$request->input('mobileno');
     $f->profession=$request->input('profession');
     $f->referenceby=$request->input('reference');
     $f->alreadymember=$request->input('alreaygymmember');
     $f->remarks=$request->input('remarks');
     $f->hearabout = $request->input('howknowaboutus');
     $f->save();


     $notificationdnd = Notification::where('mobileno',$request->input('mobileno'))->first();

        $notification = [

                    'mobileno' => $request->input('mobileno'),
                    'sms'  =>'1',
                    'email' => '1',
                    'call' => '1',
                   ];

        if ($notificationdnd) {

           Notification::where('mobileno',$request->input('mobileno'))->update($notification);

        }else{

           DB::table('notification')->insert($notification);

        }

      return redirect('inquiry')->with('message','Succesfully Edited');
    }

    $inquiry = Inquiry::find($id);
    $followup = Followup::where('inquiryid',$id)->first();


    return view('admin.editInquiry',compact('inquiry','id','followup'));
  }

  public function viewconfirmedinquiry(Request $request){

    $inqs =  DB::table('inquiries')->select('inquiries.remarks AS iremarks','inquiries.*','followup.*')->leftjoin('followup','inquiries.inquiriesid','=','followup.inquiryid')->where('inquiries.status' ,2)->paginate(10);
    //dd($inqs);
    return view('admin.viewconfirmedinquiry',compact('inqs'));
  }

  public function convertmember($id){
    $member = Inquiry::findOrFail($id);

    $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
    $RootScheme = RootScheme::get()->all();
    $users = User::get()->all();
    $PaymentTypes = PaymentType::get()->all();
    $company = Company::get()->all();
    return view('admin.addMemberfromconfirminquiry',compact('member','exerciseprogram','RootScheme','users','PaymentTypes','company'));
  }

  public function add_inquiry()
  {

    //dd('new');
   
    $packages = DB::table('schemes')->select('schemeid','schemename')->get()->all();

    $poc=DB::table('employee')->select('username')->where('role','!=','trainer')->get()->all();
    $pocarray=[];
    if($poc){

      foreach ($poc as $key => $value) {
       array_push($pocarray, $value->username);
     }
   }


   return view('admin.addinquiry',compact('packages','pocarray'));
  }
 
  public function inquiryotpverify(Request $request){

   $code = $request->get('txtotp');

            //dd($request->mobileno);

   $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->first();


   if($q){
    $q->isexpired = 1;
    $q->save();

    if($q){
      echo 'Verified';
    }
    }
  }

  public function otpverify(Request $request){



   $mobileno = $request->get('mobileno');
   $email = $request->get('email');

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

    $your = "Your";
    $is = "is:".$rndno;
    $fit = "FITNESS5";
    $otp="OTP";
  } 

  public function postverify(Request $request){

   $inquiry_mobile_no = DB::table('inquiries')->get()->last();

   $code = $request->get('otp');

   $mobileno = $request->get('mobileno');
   $mobile_no = $inquiry_mobile_no->mobileno;


   if ($code == '') {

    $skipotp = DB::table('otpverify')->get()->last();

    $data = [
      'isexpired' => '2',
    ];

    DB::table('otpverify')->where('mobileno','=',$mobile_no)->update($data);

    return redirect('inquiry');
            // return redirect('viewconfirmedinquiry');

    }


    $q=OTPVerify::where('code',$code)->where('isexpired','!=','1')->where('created_at', '>',
     Carbon::now()->subMinute(30)->toDateTimeString())->first();

    if($q){
      $q->isexpired = 1;
      $q->save();

      if($q){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('OTP Verified');
          </SCRIPT>");
      }

      return redirect('inquiry');
    }
    else{
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Worng OTP !! please redend OTP');
        </SCRIPT>");

      return view('admin.otpresend',compact('inquiry_mobile_no'));
    }
  }

  public function inquiryotpsend(Request $request){

   $mobileno = $request->get('mobileno');
   $email = $request->get('email');
   $fname = $request->get('fname');
   $lname = $request->get('lname');

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
                  $msg= str_replace("[FirstName]",$fname,$msg);
                  $msg= str_replace("[LastName]",$lname,$msg);       
                  $msg= str_replace("[otp]",$rndno,$msg);  
                  $msg2 = $msg;
                  // dd($msg);               

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
          $action->subject = 'Inquiry Otp Send';
          $action->save();

        }

    // $your = "Your";
    // $is = "is:".$rndno;
    // $fit = "FITNESS5";
    // $otp="OTP";


    // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$your.'+'.$fit.'+'.$otp.'+'.$is.'&route=6')->get(); 
    echo 'yes';
  }

  public function create(Request $request){

    // dd($request->toArray());

    if ($request->isMethod('post'))
    {
      $v = $request->validate([
        'firstname' => 'required|max:255',
        'lastname' => 'required|max:255',
        'gender' => 'required',
        'email' => 'required|email|max:255',
        'phoneno' =>'required|max:10',   
        'menberinothergym' => 'required',
        'hereaboutus' => 'required',
        'reference' => 'required',
        'package'  => 'required',
        'poc' => 'required',
        'inquirytype' => 'required',
        'inquiryrate' => 'required',
        'readytomember' => 'required',       
      ]);

      $usr = Inquiry::where('mobileno', $request['phoneno'])->get()->all();

      if($usr){
        return redirect('inquiry')->with('ermessage','Inquiry Already Exists');
      }
      
      $mobileno = $request->get('phoneno');
      $firstname = $request->input('firstname');
      $lastname = $request->input('lastname');

      if($request['nextstep'] == '3'){
        $msg=   DB::table('messages')->where('messagesid','1')->get()->first();
        $msg =$msg->message;
        $msg = str_replace("[FirstName]",$firstname,$msg);
        $msg= str_replace("[LastName]",$lastname,$msg);

        // $nmd = [
        //   'mobileno' => $mobileno,
        //   'smsmsg' => $msg,
        //   'mailmsg' => '0',
        //   'callnotes' => '0',
        // ];
        $msg2 = $msg;
        $msg = urlencode($msg);

        $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
        
        if ($smssetting) {
         
           $u = $smssetting->url;
           $url= str_replace('$mobileno', $mobileno, $u);
           $url=str_replace('$msg', $msg, $url);
 
          $otpsend = Curl::to($url)->get();

           
        }

        // $otpsend = Curl::to('http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6')->get();


        $followup_call_details = DB::table('notoficationmsgdetails')->where('mobileno','=',$mobileno)->get()->first();
        //dd($followup_call_details);

        if(!$followup_call_details){

          $action = new Notificationmsgdetails();
          $action->user_id = session()->get('admin_id');
          $action->mobileno = $mobileno;
          $action->smsmsg = $msg;
          $action->smsrequestid = $otpsend;
          $action->subject = 'Inquiry Create';
          $action->save();

          // DB::table('notoficationmsgdetails')->insert($nmd);
        }
      }

      if($request['nextstep'] == '2'){
      }

      if($request['nextstep'] == '1'){
      }


      if($request->input('readytomember') == 'Member'){
        $member = $request->all();
        $data = [
          $firstname = $request->input('firstname'),
          $lastname = $request->input('lastname'),
          $email = $request->input('email'),
          $phoneno = $request->input('phoneno'),
          $gender = $request->input('gender'),
          $profession = $request->input('profession'),
          $menberinothergym = $request->input('menberinothergym'),
          $hereaboutus = $request->input('hereaboutus'),
          $reference = $request->input('reference'),
          $remark = $request->input('remark'),
          $readytomember = $request->input('readytomember'),
          $fdate = !empty($request->input('fdate')) ?  'fdate': date('Y-m-d'),
          $ftime = $request->input('ftime'),
          $stime = $request->input('stime'),
          $packages = $request->input('package'),
          $poc = $request->input('poc'),
          $inquirytype = $request->input('inquirytype'),
          $inquiryrate = $request->input('inquiryrate'),
          $note = $request->input('note'),

        ];

        // dd($data);

        $emailsetting =  Emailsetting::where('status',1)->first();

        if (!empty($emailsetting)) {

        $data = [
                             //'data' => 'Rohit',
               'msg' => $msg2,
               'mail'=> $request->input('email'),
               'subject' => $emailsetting->hearder,
               'senderemail'=> $emailsetting->senderemailid,
            ];


        Mail::send('admin.name', ["data1"=>$data], function($message) use ($data){

                $message->from($data['senderemail'], 'Inquiry Message');
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
          $action->messagefor = 'Inquiry Mail';
          $action->save();

        }



        $createddate = Carbon::now()->toDateString();

        $inquiry_table_data = [
          'createddate' => $createddate,
          'firstname' => $firstname,
          'lastname'  => $lastname,
          'gender'  => $gender,
          'email'  => $email,
          'mobileno' => $phoneno,
          'profession' => $profession,
          'referenceby' => $reference,
          'alreadymember' => $menberinothergym,
          'remarks' => $remark,
          'hearabout' => $hereaboutus,
          'packagename' => $packages,
          'poc' => $poc,
          'rating' => $inquiryrate,
          'inquirytype' => $inquirytype,
          'note' => $note,
          'status' => '3',
          'reason' => 'Convert Into Member',

        ];

        $id =  DB::table('inquiries')->insertGetId($inquiry_table_data);

        $inquiry=Inquiry::findOrFail($id);

        $inquiry->status = '0';
        $inquiry->save();

        $followup_table_data =[
          'inquiryid'=> $id,
          'userid'=> '2',
          'followuptime'=> $request['ftime'],
          'remarks'=> $remark,
          'followupdays'=> $request['FollowUpDays'],
          'status'=> '2',
          'reason' => 'Convert Into Member',
        ];

        DB::table('followup')->insert($followup_table_data);

        $followupcalldetails = [
        'inquiriesid' => $id,
        'calldate' => $fdate,

        'callcompletedby'=>$poc,

        'callnotes' => 'Followup Added !',
        'scheme' =>$packages,
        'callrating'=>$inquiryrate,
        'created_at'   => date('Y-m-d  H:i:s'),
        'updated_at'  => date('Y-m-d  H:i:s'),  
      ];

      DB::table('followupcalldetails')->insert($followupcalldetails);

        if(Followup::where('inquiryid',$id)->get()->first()){
          $followup=Followup::where('inquiryid',$id)->get()->first();

          $followup->status = '4';
          $followup->reason = 'Close Inquiry';
          $followup->save();
        }

        $exerciseprogram = DB::getSchemaBuilder()->getColumnListing('exerciseprogram');
        //dd($exerciseprogram);
        $RootScheme = RootScheme::get()->all();
        $users = User::get()->all();
        $PaymentTypes = PaymentType::get()->all();
        $company = Company::get()->all();
        return view('admin.addMemberfrominquiry',compact('member','exerciseprogram','RootScheme','users','PaymentTypes','company'));
      }


      $createddate   = Carbon::now()->toDateString();

      $inquiries_id = DB::table('inquiries')->select('inquiriesid')->get()->last();

      $data = [
        $firstname = $request->input('firstname'),
        $lastname = $request->input('lastname'),
        $email = $request->input('email'),
        $phoneno = $request->input('phoneno'),
        $gender = $request->input('gender'),
        $profession = $request->input('profession'),
        $menberinothergym = $request->input('menberinothergym'),
        $hereaboutus = $request->input('hereaboutus'),
        $reference = $request->input('reference'),
        $remark = $request->input('remark'),
        $readytomember = $request->input('readytomember'),
        $fdate = $request->input('FollowUpDays'),
        $ftime = $request->input('ftime'),
        $stime = $request->input('stime'),
        $packages = $request->input('package'),
        $poc = $request->input('poc'),
        $inquirytype = $request->input('inquirytype'),
        $inquiryrate = $request->input('inquiryrate'),
        $note = $request->input('note'),
      ];

      $inquiry_table_data = [
        'createddate' => $createddate,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'gender'  => $gender,
        'email'  => $email,
        'mobileno' => $phoneno,
        'profession' => $profession,
        'referenceby' => $reference,
        'alreadymember' => $menberinothergym,
        'remarks' => $remark,
        'hearabout' => $hereaboutus,
        'status' => '1',
        'packagename' => $packages,
        'poc' => $poc,
        'rating' => $inquiryrate,
        'inquirytype' => $inquirytype,
        'note' => $note,
      ];

      $id =  DB::table('inquiries')->insertGetId($inquiry_table_data);
      
      $followup_table_data =[
        'inquiryid'=> $id,
        'userid'=> '2',
        'followuptime'=> $request['ftime'],
        'followupspecifictime' => $request['stime'],
        'remarks'=> $remark,
        'followupdays'=> $request['FollowUpDays'],
        'status'=> '1',
        'reason' => 'pending',
      ];

      $followupcalldetails = [
        'inquiriesid' => $id,
        'calldate' => $fdate,

        'callcompletedby'=>$poc,

        'callnotes' => 'Followup Added !',
        'scheme' =>$packages,
        'callrating'=>$inquiryrate,
        'created_at'   => date('Y-m-d  H:i:s'),
        'updated_at'  => date('Y-m-d  H:i:s'),  
      ];




      DB::table('followupcalldetails')->insert($followupcalldetails);               
      DB::table('followup')->insert($followup_table_data);

      $inquiry_mobile_no = DB::table('inquiries')->get()->last();

      $notification = [

        'mobileno' => $mobileno,
        'sms'  =>'1',
        'email' => '1',
        'call' => '1',
      ]; 

      DB::table('notification')->insert($notification);



      return redirect('inquiry')->with('message', 'Succesfully added');
    }


  }
   public function getinquiryexcelreport(){

$grid=Inquiry::leftJoin('followup','inquiries.inquiriesid','=','followup.inquiryid')->get()->all();

            if($grid){
       $student_array[] = array('InquiryDate','Name','FollowupDate','Gender','Mobileno','Package');

    foreach ($grid as $student)
    {
      
        $student_array[] = array(
            'InquiryDate' => date("d-m-Y", strtotime($student->createddate)),
            'Name' =>$student->firstname.' '.$student->lastname,
            'FollowupDate'      => date("d-m-Y", strtotime($student->followupdays)),
            'Gender'      => $student->gender,
            'Mobileno'   => $student->mobileno,
            'Package'   => $student->packagename,
           
        );
    }

    $myFile=  Excel::create('salesdet', function($excel) use ($student_array) {
                    $excel->sheet('mySheet', function($sheet) use ($student_array)
                    {

                       $sheet->fromArray($student_array);

                    });
               });


   $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
$response =  array(
   'name' => "Inquiry Report", //no extention needed
   'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
);
return response()->json($response);
   echo 'Success';

    }
}
  public function viewclosedinquiry(Request $request){
      $members = Inquiry::where('status',0)->paginate(10);
      return view('admin.viewclosedinquiry',compact('members'));
  }

}

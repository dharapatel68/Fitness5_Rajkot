<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Auth; 
use DB; 
use Hash; 
use App\Admin; 
use App\Member; 
use App\Files; 
use Illuminate\Support\Facades\Input; 
use Session;
use Carbon\Carbon; 
use App\Payment; 
use App\Role; 
use App\MemberPackages; 
use App\Scheme; 
use App\User_log; 
use App\User; 
use App\DeviceFetchlogs; 
use Illuminate\Pagination\LengthAwarePaginator; 
use DateTime; 
use App\Inquiry; 
use App\Followup; 
use Mail; 
use App\Registration; 
use App\ApiTrack; 
use PHPMailerAutoload; 
use Curl; 
use App\Ptmember;
use App\Measurement;



class AdminController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('admin.dashboad');
    }

    
    public function dashboard(Request $request){
 
       $today = Carbon::today();
      $today= $today->format('Y-m-d');
      $numberofinquiry =0;
      $numberofinquirytoday=0;
      $numberofinquirythismonth='';
      $data=[];
      $inq= DB::table('inquiries')->where('createddate',$today)->get()->all();
      if($inq){
        $numberofinquirytoday = count($inq);
      }

      $inquirytotal = DB::table('inquiries')->get()->all();
      $numberofinquirytotal = count($inquirytotal);
      $data['numberofinquirytoday'] =$numberofinquirytoday;
      $month= date('m');
      $data['numberofinquirythismonth'] = DB::table('inquiries')->whereMonth('created_at', '=', $month)->get()->count();

      $data['numberofinquirytotal'] =$numberofinquirytotal;
      
      $numberofmembertoday =0;
      $member= DB::table('member')->where('createddate',$today)->get()->all();

      if($member){
        $numberofmembertoday = count($member);
      }
      $membertotal = DB::table('member')->get()->all();
      $numberofmembertotal = count($membertotal);
      $data['numberofmembertotal'] =$numberofmembertotal;
      $data['numberofmembertoday'] =$numberofmembertoday;
      $data['numberofmemberthismonth'] = DB::table('inquiries')->whereMonth('created_at',$month)->get()->count();


      $followup=Inquiry::leftjoin('followup','followup.inquiryid','inquiries.inquiriesid')->where('followup.followupdays',date('Y-m-d'))->where('followup.status',"1")->paginate(5);
      $users=User::get()->all();
      $regs=Registration::get()->all();
      $regstoday=Registration::whereDate('created_at',$today)->get()->all();
      $registrationtoday=count($regstoday);
      $registrationtotal=count($regs);
      $data['registrationtoday'] =$registrationtoday;
      $data['registrationtotal'] =$registrationtotal;

      $data['reregistration']=Registration::select('phone_no')
                              ->selectRaw('count(`phone_no`) as `occurences`')
                              ->groupBy('phone_no')
                              ->having('occurences', '>', 1)
                              ->get()->count();
      $paymenttoday =0;

      $payment= DB::table('payments')->where('date','=',$today)->whereIn('mode',['no mode','total'])->get()->all();
      if($payment){
        $paymenttoday = count($payment);
      }
      $paymenttotal = DB::table('payments')->where('mode','no mode')->orwhere('mode','total')->get()->all();
      $paymenttotal = count($paymenttotal);
      $data['paymenttotal'] =$paymenttotal;
      $data['paymenttoday'] =$paymenttoday;


      // $payment = Payment::select(['payments.memberid as mid','payments.*'])->with('Scheme.RootScheme')->leftJoin('member','member.memberid','=','payments.memberid')->where('mode','!=','total')->paginate(10);
// DB::enableQueryLog();

     
      // $filterquery =  DB::select("SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total)  from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid,  temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments` left join schemes on schemes.schemeid = payments.schemeid GROUP by payments.schemeid, DATE_FORMAT(payments.date,  '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid 
      //    GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename");
      // // dd($filterquery);
      // $rootschemes= RootScheme::get()->all();
//       foreach($rootschemes as $paymentcollection){

//         $filterquery1 =  DB::select("SELECT tmp2.rootschemeid, rootschemes.rootschemename,tmp2.date, SUM(tmp2.Total)  from rootschemes JOIN (SELECT tmp1.rootschemeid, rootschemes.rootschemename, tmp1.schemeid, tmp1.date, tmp1.Total from rootschemes join (select schemes.rootschemeid,  temp.schemeid, temp.date, temp.Total from schemes JOIN (SELECT payments.schemeid, DATE_FORMAT(payments.date, '%d-%m-%Y') date, SUM(payments.amount) Total FROM `payments` left join schemes on schemes.schemeid = payments.schemeid GROUP by payments.schemeid, DATE_FORMAT(payments.date,  '%d-%m-%Y') ) temp on schemes.schemeid = temp.schemeid) tmp1 on rootschemes.rootschemeid = tmp1.rootschemeid ORDER BY tmp1.date) tmp2 on rootschemes.rootschemeid = tmp2.rootschemeid   WHERE MONTH(tmp2.date) = 12  GROUP by tmp2.date, tmp2.rootschemeid, rootschemes.rootschemename");
// // dd($filterquery1);
//         $paymentcollection['total']=$paymentcollection['total']+$filterquery1->total;
//       }

   // dd(DB::getQueryLog());
      $today_date = date('Y-m-d');
      $finalarray = [];

      if(!empty($filterquery)){

        foreach ($filterquery as $key => $query) {
          //dd($payment_today);
          $year = date('Y');
          $query->schemeid;
           $payment_year = Payment::where('schemeid',$query->schemeid)->sum('payments.amount');
   
           
          $payment_month = Payment::leftjoin('schemes', 'payments.schemeid', 'schemes.schemeid')->leftjoin('rootschemes', 'schemes.schemeid', 'rootschemes.rootschemeid')->select(DB::raw("SUM(payments.amount) as monthamount"))->where('payments.mode', 'total')->groupBy('rootschemes.rootschemeid')->where('schemes.schemeid', $query->schemeid)->whereMonth('payments.paymentdate', $month)->first();
  // dd($payment_month);

          if(!empty($payment_month)){
             $payment_year['month_payment'] = $payment_month['monthamount'];

          }
          $payment_today = Payment::leftjoin('schemes', 'payments.schemeid', 'schemes.schemeid')->leftjoin('rootschemes', 'schemes.schemeid', 'rootschemes.rootschemeid')->select(DB::raw("SUM(payments.amount) as todayamount"))->whereDate('paymentdate', $today_date)->where('schemes.schemeid', $query->schemeid)->where('mode', 'total')->groupBy('rootschemes.rootschemeid')->first();
          // dd($payment_today);
         if(!empty($payment_today)){

          $payment_year['day_payment'] = $payment_today['todayamount'];
          }


          array_push($finalarray, $payment_year);


        }
  
 
          $currentPage = LengthAwarePaginator::resolveCurrentPage();
          $collection = collect($finalarray);
          $perPage = 10;
          $currentPageItems = $collection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
          $paginatedItems= new LengthAwarePaginator($currentPageItems , count($collection), $perPage);
          $paginatedItems->setPath($request->url());
          $collection=$paginatedItems;

      }
$duepayment = Payment::leftJoin('member','member.memberid','=','payments.memberid')->whereRaw('paymentid IN (select MAX(paymentid) FROM payments GROUP BY memberid)')->where('payments.remainingamount', '>',0)->paginate(5);
 // dd($duepayment);

$packageexpirenearlydate=date('Y-m-d');
// dd($packageexpirenearly);
 $packageexpirenearly=[];

  
    $now =  date('Y-m-d', strtotime(' + 15 days'));
    $packages = MemberPackages::where('memberpackages.status',1)->leftjoin('member','member.userid', 'memberpackages.userid')->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')->where('memberpackages.expiredate','<',$now)->get()->all();

    foreach ($packages as $key => $pack) {

    $r= MemberPackages::where('memberpackages.status',1)->where('memberpackages.expiredate','<',$now)->leftjoin('member','member.userid', 'memberpackages.userid')->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')-> where('schemes.rootschemeid','=',$pack->rootschemeid)->where('memberpackages.expiredate','>',$pack->expiredate)->get()->all();
    if($r){
      
    }
    else{
      // dd($pack);
          $date1=date_create( $pack->expiredate);
          $date2=date_create( date('Y-m-d'));

          $diff=date_diff($date2,$date1);
          /*if diff is positive*/
          if($diff->invert == 0 ){
              if($diff->days == 0){
                     $diff='Today';
             $pack->diff = $diff;
              }
              else{
                $diff=$diff->format("%R%a days");
             $pack->diff = $diff;
              }
             

            array_push($packageexpirenearly, $pack);
          }
          /*if diff is negative*/
          else{
            $diff=$diff->format("%R%a days");
            if($diff <= -7){
            }
            else{
              // $diff=$diff->format("%R%a days");
              $pack->diff = 'Expired';
              array_push($packageexpirenearly, $pack);

            }
          }
    

      
    }
    
    }

    $currentPage = LengthAwarePaginator::resolveCurrentPage();
          $packageexpirenearly = collect($packageexpirenearly);
          $perPage = 10;
          $currentPageItems = $packageexpirenearly->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
          $paginatedItems= new LengthAwarePaginator($currentPageItems , count($packageexpirenearly), $perPage);
          $paginatedItems->setPath($request->url());
          $packageexpirenearly=$paginatedItems;
    
$today=date('Y-m-d 00:00:00');

    $membercounttoday='';
       $membercounttotal='';
     $membercounttoday= User_log::leftjoin('users','users.userid','user_log.UserId')->where('user_log.PunchDateTime', 'LIKE', $today)->where('user_log.UserId','!=',0)->whereIn('users.userstatus',['reg','mem'])->get()->all();
     // dd($today);
    // dd($membercounttoday);
     $membercounttoday=count($membercounttoday);
 

    
    $membercounttotal=User_log::leftjoin('users','users.userid','user_log.UserId')->where('user_log.UserId','!=',0)->whereIn('users.userstatus',['reg','mem'])->get()->all();
     $membercounttotal=count($membercounttotal);
     // dd($membercounttoday);
      $data['membercounttotal'] =$membercounttotal;
      $data['membercounttoday'] =$membercounttoday;
    //dd($packageexpirenearly);

    $followup=Inquiry::leftjoin('followup','followup.inquiryid','inquiries.inquiriesid')->where('followup.followupdays',date('Y-m-d'))->where('followup.status',"1")->paginate(5);
    $users=User::get()->all();
    $regs=Registration::get()->all();
    $regstoday=Registration::whereDate('created_at','LIKE',$today)->get()->all();
    $registrationtoday=count($regstoday);
    $registrationtotal=count($regs);
    $data['registrationtoday'] =$registrationtoday;
    $data['registrationtotal'] =$registrationtotal;

    $data['reregistration']=Registration::select('phone_no')
              ->selectRaw('count(`phone_no`) as `occurences`')
              ->groupBy('phone_no')
              ->having('occurences', '>', 1)
              ->get()->count();
     
      $data['footsteptoday'] =User_log::whereDate('created_at',$today)->count();  
      $data['footsteptotal'] =User_log::count(); 
      $data['footstepthismonth'] =User_log::whereMonth('created_at', '=', $month)->get()->count();
// dd($packageexpirenearly);

   /* $packages =  DB::select( DB::raw('SELECT * FROM `memberpackages` JOIN member on member.userid = memberpackages.userid JOIN schemes on schemes.schemeid = memberpackages.schemeid where memberpackages.expiredate = (SELECT MAX(memberpackages.expiredate) FROM memberpackages where member.userid = memberpackages.userid)')); 


    foreach ($packages as $key => $pack) {
        $date = Carbon::parse($pack->expiredate);
        $now = Carbon::now();

        $date1=date_create( $date);
        $date2=date_create($now);
        $diff=date_diff($now,$date);
/* $diffprint for print in blade file  */
/* $d for  format print in blade file  */
/* $diff days between two date  */
      /*  $diff=$diff->format("%R%a days");

        if($diff==15 || $diff < 15){
         
        if($date1 < $date2){
          
           if($diff <= -7){
            $d = null;
           }
           if($diff == -0){
            $d = 'Today';
           }
           else{
            $d='Expired';

           }

           $diffprint= $d != null ? $d :'' ;

        } 
        if($date1 > $date2){
           $d=$diff;
           if($d==+0){
            $d='Tommorow';
            $diffprint=$d;
           }else{

            $diffprint=$d;
           }
        } 

         $pack->diff = $diffprint;
         $pack->d=$diff;
        if($pack->diff){
        array_push($packageexpirenearly, $pack);
        }

}


    }

   dd($packageexpirenearly);*/

  $collection='';
  $packexpiretrainer=array();
 $trainerid=$this->auth=Session::get('employeeid');
  $packexpiretrainerall=Ptmember::where('trainerid', $trainerid)->groupBy('memberid')->pluck('memberid')->all();
   // dd($packexpiretrainerall);
  foreach ($packexpiretrainerall as $key => $value) {
    $member=Member::where('memberid',$value)->get()->first();
     $memberpackage= MemberPackages::leftjoin('member','member.userid','memberpackages.userid')->where('memberpackages.userid',$member->userid)->orderBy('memberpackages.expiredate', 'desc')->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')->get()->first();

      $date1=date_create( $memberpackage->expiredate);
          $date2=date_create( date('Y-m-d'));

          $diff=date_diff($date2,$date1);
            // dd( $diff);
          /*if diff is positive*/
          if($diff->invert == 0 ){
              if($diff->days == 0){
                $diff='Today';
                $finaldiff = $diff;
              }
              else{
                $diff=$diff->format("%R%a days");
                $finaldiff = $diff;
              }
          }
          /*if diff is negative*/
          else{
            $diff=$diff->format("%R%a days");
            // dd( $diff);
            if($diff < -7){
              $finaldiff ='';
            }
            else{
              // $diff=$diff->format("%R%a days");
              $finaldiff = 'Expired';
            }
          }
     // $memberpackage=MemberPackages::where('userid',$member->userid)->get()->all();
      // $memberpackage=DB::select( DB::raw("SELECT * FROM `memberpackages` left JOIN member on member.userid = memberpackages.userid where memberpackages.userid = '".$member->userid."' AND memberpackages.expiredate = (SELECT MAX(expiredate) from memberpackages where userid = ".$member->userid.")"));
      if($finaldiff){
        $memberpackage['diff']=$finaldiff;
        array_push($packexpiretrainer, $memberpackage);
      }

  }
   $trainersession=Ptmember::where('trainerid', $trainerid)->leftjoin('member','member.memberid','ptmember.memberid')->leftjoin('schemes','schemes.schemeid','ptmember.schemeid')->whereIn('ptmember.status',['Active','Pending'])->select('member.*','ptmember.*','ptmember.status as ptstatus','schemes.schemename')->paginate(8);
// dd($trainersession);
   $measurements=Measurement::leftjoin('member','member.memberid','measurement.memberid')->paginate(8);

      return view('admin.dashboard',compact('data','collection','payment','duepayment','packageexpirenearly','followup','packexpiretrainer','trainersession','measurements'));
     }
     public function loaduserbytype(Request $request){
 ;
   $users=User::where('username','LIKE','%'.$request->typehead)->orwhere('username','LIKE',$request->typehead.'%')->where('empid',0)->join('member','member.userid','users.userid')->get()->all();


   return $users;

}
public function loaduserprofile(Request $request){
 ;
   $userpro=User::where('users.userid',$request->userid)->leftjoin('member','member.userid','users.userid')->get()->first();
   $userpropackges=array();
   $packages = MemberPackages::where('memberpackages.userid',$request->userid)->leftjoin('schemes','schemes.schemeid','memberpackages.schemeid')->get()->all();
   $month=date('m');

    $logs= User_log::where('UserId',$request->userid)->whereMonth('PunchDateTime',$month)->get()->all();

   $userpro['packages']=$packages;

   $userpro['logs']=$logs;
   return $userpro;
}
  public function check(Request $request){


       if($request->isMethod('post'))
      {
        $admin[0]='';
        $admin = DB::table('admin')->where(['username'=>$request->username])->get();

        $usernamedata=$request->username;
        if(count($admin)!=0)
        $employeeid=$admin[0]->employeeid;


    $u=Admin::where('username', Input::get('username'))->first();

        if ($u) {

          if (Hash::check(Input::get('password'), $u->password)) {

            $role=$u->role;

            $permission = Role::where('employeerole', $role)->first();

            if(empty($permission->permission)){
             $permission = '';
            } else {
             $permission = $permission->permission;
            }

            session(['username' => $usernamedata]);
            session(['role' =>  $role]);
            session(['employeeid' =>  $employeeid]);
            session(['admin_id' => $u->adminid]);
            session(['permission' =>  $permission]);
          // dd(session());
            return redirect('dashboard');  
           // return response()->json(['success'=>false, 'message' => 'Login successfull']);
          }
          else{
   		
                $msg = 'Invalid Username or Password';
                return redirect('check')->with('message',$msg);
          
          }
        }
        else{
           $msg = 'Invalid Username or Password';
             return redirect('check')->with('message',$msg);
        }

      }
      
      return view('admin.admin_login');
    
   }
  public function loginpage(){

    $this->auth=Session::get('role');
    
    $role=['admin','receptionist','manager','trainer','member'];
        if (in_array($this->auth, $role)) {
            // return abort(403, "No access here, sorry!");
          return redirect('dashboard');
        }
        else
        {
             $msg = 'Invalid Username or Password';
            return view('admin.admin_login')->with('msg');
         
        }

      
    }
   
       public function logout(Request $request){
         //auth()->logout();
		Session::flush();
       //return redirect('/check')->with('msgsuccess', 'Succesfully logged out');
		   return redirect('adminloginpage');
     }




     public function todaymember(){


      $today=date('Y-m-d');
     
      $membercounttotal=DeviceFetchlogs::leftjoin('users','users.userid','devicefetchlogs.detail1')->where('devicefetchlogs.date',$today)->where('devicefetchlogs.detail1','!=',0)->where('users.userstatus', '!=','emp')->groupBy('detail1')->orderBy('detail1','DESC')->select('detail1')->get()->all();
      //dd($membercounttotal);
      $memberdata = [];
      if(!empty($membercounttotal)){
        foreach ($membercounttotal as $key => $member) {

            $checkin = DeviceFetchlogs::where('detail1', $member->detail1)->pluck('time')->first();
            $checkout = DeviceFetchlogs::where('detail1', $member->detail1)->latest('time')->pluck('time')->first();
            $username = User::where('userid', $member->detail1)->pluck('username')->first();
            $data = ['username' => $username, 'checkin' => $checkin, 'checkout' => $checkout];
            array_push($memberdata, $data);
          
        }
      }


      return view('admin.todaymember')->with(compact('memberdata'));


     }


     public function testapi(){
      
        $api = ApiTrack::where('api', 'like', '%165.22.250.103:8443%' )->get()->all();
        
        foreach($api as $apidata){
          $apicontent = str_replace('165.22.250.103:8443', '165.22.250.103:8080', $apidata->api);

          $apiupdate = ApiTrack::where('apitrackid', $apidata->apitrackid)->first();
          if(!empty($apiupdate)){
            $apiupdate->api = $apicontent;
            $apiupdate->save();
          }

         /* $packageexpiry = Curl::to($apicontent)->get();
          echo "<pre>";print_r($packageexpiry);*/

        }



     }
}
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
      $data=[];
      $inq= DB::table('inquiries')->where('createddate',$today)->get()->all();
    if($inq){
      $numberofinquirytoday = count($inq);
    }
    $inquirytotal = DB::table('inquiries')->get()->all();
    $numberofinquirytotal = count($inquirytotal);
    $data['numberofinquirytoday'] =$numberofinquirytoday;
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

    $paymenttoday =0;

    $payment= DB::table('payments')->where('date','=',$today)->whereIn('mode',['no mode','total'])->get()->all();
    if($payment){
      $paymenttoday = count($payment);
    }

    $paymenttotal = DB::table('payments')->where('mode','no mode')->orwhere('mode','total')->get()->all();
    $paymenttotal = count($paymenttotal);
    $data['paymenttotal'] =$paymenttotal;
    $data['paymenttoday'] =$paymenttoday;


    $payment = Payment::with('Scheme.RootScheme')->leftJoin('member','member.memberid','=','payments.memberid')->where('mode','!=','total')->where('type','credit')->get()->all();


    $duepayment = Payment::leftJoin('member','member.memberid','=','payments.memberid')->whereRaw('paymentid IN (select MAX(paymentid) FROM payments GROUP BY memberid)')->get()->toArray();
    $packageexpirenearlydate=date('Y-m-d');
   
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
    $today=date('Y-m-d');

    $membercounttoday='';
       $membercounttotal='';
       DB::enableQueryLog();

           $membercounttoday= DeviceFetchlogs::leftjoin('users','users.userid','devicefetchlogs.detail1')->where('devicefetchlogs.date',$today)->where('devicefetchlogs.detail1','!=',0)->whereIn('users.userstatus',['reg','mem'])->get()->all();
   /* dd(DB::getQueryLog());*/
     $membercounttoday=count($membercounttoday);
 

    
    $membercounttotal=DeviceFetchlogs::leftjoin('users','users.userid','devicefetchlogs.detail1')->where('devicefetchlogs.detail1','!=',0)->whereIn('users.userstatus',['reg','mem'])->get()->all();
     $membercounttotal=count($membercounttotal);
     // dd($membercounttoday);
      $data['membercounttotal'] =$membercounttotal;
      $data['membercounttoday'] =$membercounttoday;
    

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
  

      return view('admin.dashboard',compact('data','payment','duepayment','packageexpirenearly'));
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
            session(['employeeid' => $u->employeeid]);
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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use App\Smssetting;
use Ixudra\Curl\Facades\Curl;
use App\MemberData;
use App\Message;

class SendMemberFormController extends Controller
{
   public function sendmemberform(Request $request)
    {	
        if($request->isMethod('post')){
            $id=$request->mobileno;
           
    	    $link_send = url('/').'/'.$id.'/addmember';
           $msg= Message::where('messagesid',18)->get()->first();
           $msg=$msg->message;
           $firstname=$request->firstname;
      
            $lastname=$request->lastname;
            $msg ='Dear '.$firstname.' '.$lastname.' '.$msg; 
            
            $bitlylink = app('bitly')->getUrl($link_send);
            ShortLink::create([
                'code'=>$id,
                'link'=>$link_send,
                'shortenlink'=>$bitlylink,
                'status'=>1
            ]);
            $msg= str_replace("[url]", $bitlylink,$msg); 
            // $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
            $u = "http://vsms.vr4creativity.com/api/mt/SendSMS?number=mobileno&text=msg&user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&route=6";
            $msg = urlencode($msg);
            $url= str_replace('mobileno',$id, $u);
            $url=str_replace('msg', $msg, $url);
            $otpsend = Curl::to($url)->get();
            
            return redirect()->back()->withSuccess('Form SuccesFully Send');
        }
    }
    public function addmeber(Request $request,$id){
        $shortlink=ShortLink::where('code',$id)->get()->last();
        if($shortlink){
            if($shortlink->status==1){
                  include public_path().'/addmember.php';
            }else{
                include public_path().'/alreadysubmitted.php';
            }

        }
        else{
                return abort(404);
            }

    }
     public function viewrequests(Request $request){
        $memberdata=MemberData::where('status',1)->where('answer',2)->orderBy('memberid','desc')->get()->all();
        return view('admin.Memberform.allrequests',compact('memberdata'));

    }
    public function sendformtonumber(Request $request){

            return view('admin.Memberform.sendformtonumber');
        

    }
    public function changeMemberStatus(Request $request){
        $memberdata=MemberData::where('memberid',$request->id)->get()->first();
        $memberdata->status=1;
        $memberdata->save();
        return 'success';
    }
    public function rejectrequest(Request $request,$id){
        $memberdata=MemberData::where('memberid',$request->id)->get()->first();
        $memberdata->answer=3;
        $memberdata->save();
        return  redirect()->back()->withSuccess('SuccesFully Rejected');
    }
    
    
    
}

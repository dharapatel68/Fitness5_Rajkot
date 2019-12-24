<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use App\Smssetting;
use Ixudra\Curl\Facades\Curl;
use App\MemberData;

class SendMemberFormController extends Controller
{
   public function sendmemberform(Request $request,$id,$code)
    {	
    	    $link_send = url('/').'/'.$id.'/addmember';
            $msg="Link at [url]";
            $bitlylink = app('bitly')->getUrl($link_send);
            ShortLink::create([
                'code'=>$id,
                'link'=>$link_send,
                'shortenlink'=>$bitlylink,
                'status'=>1
            ]);
            $msg= str_replace("[url]", $bitlylink,$msg); 
            $smssetting = Smssetting::where('status',1)->where('smsonoff','Active')->first();
            $u = $smssetting->url;
            $msg = urlencode($msg);
            $url= str_replace('$mobileno',$id, $u);
            $url=str_replace('$msg', $msg, $url);
            $otpsend = Curl::to($url)->get();
            
            return redirect()->back()->withSuccess('Form SuccesFully Send');
    }
    public function addmeber(Request $request,$id){
        $shortlink=ShortLink::where('code',$id)->get()->last();
        if($shortlink){
            if($shortlink->status==1){
                  include public_path().'/addmember.php';
            }else{
                return abort(404);
            }

        }
        else{
                return abort(404);
            }

    }
     public function viewrequests(Request $request){
        $memberdata=MemberData::get()->all();
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
    
    
    
}

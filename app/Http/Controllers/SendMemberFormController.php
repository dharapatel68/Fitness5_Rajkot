<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendMemberFormController extends Controller
{
   public function sendmemberform(Request $request,$id)
    {
    	$url = app('bitly')->getUrl('https://www.google.com/');
    	dd($url);
    }
}

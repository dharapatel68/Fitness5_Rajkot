<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class TrainerProfileController extends Controller
{
    public function addtrainerprofile(Request $request){
    	$trainer=Employee::where('roleid',4)->get()->all();
    	return view('trainer',compact('trainer'));

    }
}

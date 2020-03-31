<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDietPlan extends Model
{

    protected $table = 'memberdietplan';
     protected $primaryKey = 'memberdietplanid';
   protected $fillable = [
   	
        'memberid','plannameid','status','fromdate','todate','created_at','updated_at'];

  	 public function DietPlanname(){

	 return $this->belongsTo('App\DietPlanname','plannameid');	
	}			
}

<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

class admin
{
     protected $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->auth=Session::get('role');
        if($this->auth){
              $role_data = DB::table('roles')->where('employeerole', $this->auth=Session::get('role'))->first();
         
                if(!empty($role_data)){
                    $is_login = $role_data->portalaccess;
                    if($is_login != 1){
                        return redirect('adminloginpage');
                    }else{
                        return $next($request);
                    }
                }else{
                    return $next($request);
                }
        }else{
                   return redirect('adminloginpage');
                }
      
         
            
       /* $role=['admin','receptionist','manager','trainer','employee'];
        if (!in_array($this->auth, $role)) {
            // return abort(403, "No access here, sorry!");
            return redirect('adminloginpage');
        }*/

        /*return $next($request);*/
    }
}
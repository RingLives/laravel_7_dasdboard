<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Procedures\ProcedueresController;

class RouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // $routeName = $request->route()->getName();
        // $company_id='';
        // if(NULL == $request->session()->get('user_role_id') && $request->session()->get('user_type') != "super_admin"){
        //     return redirect('unauthorized');
        // }
        // $company_id=session()->get('company_id');

        // $routePermission = DB::select('call get_permission("'.$request->session()->get('user_role_id').'", "'.$routeName.'","'.$company_id.'")');

        // $routePermission = ProcedueresController::get_permission($request->session()->get('user_role_id'),$routeName,$company_id);
        
        // $access = 0;
        // foreach ($routePermission as $value) {
        //     $access = $value->cnt;
        // }
        

        // if($request->session()->get('user_type') == "super_admin"){
        //     return $next($request);
        // }else if($access == 0){
        //     return redirect('unauthorized');
        // }   


        return $next($request);
    }
}

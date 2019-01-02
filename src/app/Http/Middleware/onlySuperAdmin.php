<?php

namespace App\Http\Middleware;

use Closure;

class onlySuperAdmin
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
        // if($request->session()->get('user_type') == "super_admin"){
            return $next($request);
        // }else if($access == 0){
        // }else{
        //     return redirect('unauthorized');
        // } 
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class userMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*$user = DB::table('users')->select('role_id')->first();
        if ($user && (int)$user->role_id == 2) {
            return $next($request);
        }
        else{
            return redirect()->route('login');
        }*/
        if(Auth::check() && Auth::user()->role_id == 2){
            return $next($request);
        }
        else{
            return redirect()->back()->with('unauthorized, you are not authorized to access this page ');
        }
    }
}

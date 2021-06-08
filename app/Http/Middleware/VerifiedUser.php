<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()){
            if(is_null($request->user()->email_verified_at))
                return redirect('/email/verify');
            else if(is_null($request->user()->userprofile))
                return redirect('/profile');
        }
        return $next($request);
    }
}

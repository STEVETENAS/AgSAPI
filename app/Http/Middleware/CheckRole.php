<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->admin){
                return $next($request);
            }
            else{
                return response(
                    ['message' => 'Action unauthorized!'],401
                );
            }
        }
        return response(
            ['message' => 'Unauthorized Access!'],401
        );
    }
}

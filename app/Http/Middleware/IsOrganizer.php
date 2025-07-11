<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == "organizer"){
        return $next($request);
            }else{
                return redirect(route("home"))->with("error","You are not an Organizer");
            }
        }
        else{
            return redirect(route("login"))->with("error","Please log in to continue");
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role == "customer") {
                return $next($request);
            } else {
                return redirect(route("home"))->with("error", "You are not a customer");
            }
        } else {
            return redirect(route("login"))->with("error", "Please log in to continue");
        }
    }
}

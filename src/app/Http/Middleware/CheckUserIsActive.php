<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_active) {
            Log::debug('Utilizator inactiv: ', ['user_id' => auth()->user()->id]);
            auth()->logout();
            return redirect()->route('login')->with('error', 'Contul este inactiv.');
        }
    
        return $next($request);
    }
}
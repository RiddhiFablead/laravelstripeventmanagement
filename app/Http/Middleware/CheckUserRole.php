<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if(!$request->session()->has('id'))
    //     {
    //         return redirect('/login');
    //     }
    //     $role=$request->session()->get('role');
       
    //     if($request->session()->has('id') && $role=='admin')
    //     {
    //         return redirect('dashboard');
    //     }
    //     elseif(!$request->session()->has('id') && $role=='user')
    //     {
    //         return redirect('customer.dashboard');

    //     }
    //     return redirect('/login');
      
    // }
    public function handle(Request $request, Closure $next): Response
{
    if (!$request->session()->has('id')) {
        return redirect('/login');
    }

    $role = $request->session()->get('role');

    if ($role == 'admin' && !$request->is('dashboard')) {
        return redirect('dashboard');
    } elseif ($role == 'user' && !$request->is('customer/dashboard') && !$request->is('my-bookings')) {
        return redirect('customer/dashboard');
    }

    return $next($request);
}

}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kullanıcı giriş yapmış mı ve admin mi?
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Admin değilse 404
        abort(404, 'Sayfa bulunamadı.');
        //return redirect()->route('home')->with('error', 'Yönetici paneline erişim yetkiniz bulunmuyor.');
    }
}

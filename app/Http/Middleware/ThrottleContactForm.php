<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleContactForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $blockKey = "contact_blocked:$ip";
        $attemptsKey = "contact_form_attempts:$ip";

        if (Cache::has($blockKey)) {
            return response()->json([
                'message' => 'Too many contacts attempts. Please try later.'
            ], 429);
        }

        $attempts = Cache::increment($attemptsKey);

        if ($attempts === 1) {
            Cache::put($attemptsKey, 1, now()->addMinute());
        }

        if ($attempts > 3) {
            Cache::put($blockKey, true, now()->addHour());
            Cache::forget($attemptsKey);
            return response()->json([
                'message' => 'Too many contacts attempts. Please try in 1 hour.'
            ], 429);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'failed', 'error' => 'Token not provided'], 400);
        }

        $payload = base64_decode($token);
        $check = DB::select('select * from users where name like ?', ["%{$payload}%"]);

        if (empty($check)) {
            return response()->json(['status' => 'failed', 'error' => 'Invalid token'], 400);
        }

        return $next($request);
    }
}

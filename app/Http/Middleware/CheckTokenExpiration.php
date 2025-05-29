<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormater;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $token = $request->user()->currentAccessToken();

            if ($token->expires_at && $token->expires_at->isPast()) {
                // Update user status ke offline
                $request->user()->update(['status_activity' => 'offline']);

                // Delete expired token
                $token->delete();

                return ResponseFormater::error([
                    'message' => 'Token sudah expired. Silakan login ulang.',
                    'error' => 'token_expired'
                ], 'Token Expired', 401);
            }
        }

        return $next($request);
    }
}

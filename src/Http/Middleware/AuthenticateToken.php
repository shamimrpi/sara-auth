<?php

namespace Shamimrpi\SaraAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shamimrpi\SaraAuth\Models\Token;
use Illuminate\Support\Facades\Auth;

class AuthenticateToken
{
    public function handle(Request $request, Closure $next)
    {
        $tokenValue = $request->bearerToken();

        if (!$tokenValue) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = Token::where('token', $tokenValue)->first();

        if (!$token || !$token->user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // ✅ Laravel auth()->user() কে set করা
        Auth::login($token->user);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;

class APIAuthenticateAndRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->cookie('jwtToken')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            // Attempt to authenticate the user using the token from the request (e.g., from cookie)
            if (!$token = JWTAuth::setToken($request->cookie('jwtToken'))->authenticate()) {
                // If authentication fails (token missing, invalid, etc.), redirect to login
                Helper::logging(Helper::getUsername($request), 'Auth', 'Login', 'User ' . Helper::getUsername($request) . ' token invalid');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (TokenExpiredException $e) {
            // If the token is expired, attempt to refresh it
            try {
                $refreshedToken = JWTAuth::refresh(JWTAuth::getToken());
                // Set the user on the request with the new token's user
                $token = JWTAuth::setToken($refreshedToken)->toUser();
                Helper::logging(Helper::getUsername($request), 'Auth', 'Login', 'User ' . Helper::getUsername($request) . ' token refreshed');
                $request->attributes->set('user', $token);
            } catch (JWTException $e) {
                // If refresh fails (e.g., token blacklisted, invalid), redirect to login
                Helper::logging(Helper::getUsername($request), 'Auth', 'Login', 'User ' . Helper::getUsername($request) . ' token refresh failed');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (JWTException $e) {
            // If any other JWT exception occurs (e.g., token invalid, not found), redirect to login
            Helper::logging(Helper::getUsername($request), 'Auth', 'Login', 'User ' . Helper::getUsername($request) . ' token error : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // If authentication was successful (either initially or after refresh), proceed
        Helper::logging(Helper::getUsername($request), 'Auth', 'Login', 'User ' . Helper::getUsername($request) . ' token valid');
        $response = $next($request);

        // If a new token was issued during refresh, set it in the cookie
        if (isset($refreshedToken)) {
            // Get the expiration time of the new token (in minutes)
            $ttl = JWTAuth::factory()->getTTL(); // TTL in minutes
            // Set the cookie with the new token and its expiration
            $response->headers->setCookie(cookie('jwtToken', $refreshedToken, $ttl));
        }

        return $response;
    }
}

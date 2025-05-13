<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
#[OA\Info(
    version: '1.0.0',
    title: 'PBL SIPASTI API',
    description: 'PBL SIPASTI API'
)]

class AuthController extends Controller
{

    #[OA\Schema(
        schema: 'LoginRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'email', type: 'string', example: 'test@example.com'),
            new OA\Property(property: 'password', type: 'string', example: 'password')
        ]
    )]

    #[OA\Post(
        path: '/api/login',
        summary: 'Login',
        description: 'Login to the application',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/LoginRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Login Success',
                content: new OA\JsonContent(
                    example: [
                        'success' => true,
                        'message' => 'Login successful',
                        'access_token' => 'the_token_here',
                        'user' => 'user_object_here'
                    ]
                )
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Invalid credentials',
                    ]
                )
            )
        ]
    )]
    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
        ]);
        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (Auth::attempt($credentials->validated())) {
            $user = Auth::user();
            error_log(json_encode($user));
            $token = JWTAuth::fromUser($user);
            Helper::logging($user->username, 'Auth', 'Login', 'User ' . $user->username . ' logged in');
            $cookie = cookie('jwtToken', $token, JWTAuth::factory()->getTTL() * 60);
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $user,
            ], 200)->withCookie($cookie);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Logout',
        description: 'Logout from the application',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Logout successful',
            )
        ]
    )] 

    public function logout(Request $request)
    {
        $cookie = cookie('jwtToken', '', -1);
        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ], 200)->withCookie($cookie);
    }

    
}

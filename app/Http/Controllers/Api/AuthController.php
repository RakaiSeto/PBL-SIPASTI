<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use Illuminate\Support\Facades\Hash;
use App\Models\m_user as User;

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
            new OA\Property(property: 'username', type: 'string', example: 'admin'),
            new OA\Property(property: 'password', type: 'string', example: 'sipasti123')
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
        if (!$credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
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


    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level' => 'required|string',
            'nama' => 'required|string',
            'username' => 'required|string|unique:m_user,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        if ($request->level == 'Teknisi') {
            $role = '3';
        } else if ($request->level == 'mahasiswa') {
            $role = '4';
        } else if ($request->level == 'dosen') {
            $role = '4';
        } else if ($request->level == 'tendik') {
            $role = '4';
        } else if ($request->level == 'sarpras') {
            $role = '2';
        }

        $user = User::create([
            'role_id' => $role,
            'fullname' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return response()->json(['success' => true, 'message' => 'Berhasil mendaftar']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal mendaftar']);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\m_user as User;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Hash;

class KelolaPengguna extends Controller
{
    #[OA\Schema(
        schema: 'KelolaPenggunaRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'role', type: 'string', example: ''),
            new OA\Property(property: 'search', type: 'string', example: '')
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaPenggunaCreateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'role_id', type: 'string', example: ''),
            new OA\Property(property: 'username', type: 'string', example: ''),
            new OA\Property(property: 'fullname', type: 'string', example: ''),
            new OA\Property(property: 'password', type: 'string', example: ''),
            new OA\Property(property: 'email', type: 'string', example: ''),
            new OA\Property(property: 'no_telp', type: 'string', example: ''),
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaPenggunaUpdateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'role_id', type: 'string', example: ''),
            new OA\Property(property: 'username', type: 'string', example: ''),
            new OA\Property(property: 'fullname', type: 'string', example: ''),
            new OA\Property(property: 'email', type: 'string', example: ''),
            new OA\Property(property: 'no_telp', type: 'string', example: ''),
        ],
    )]

    #[OA\Post(
        path: '/api/kelola-pengguna',
        summary: 'Get list of users',
        description: 'Get list of users with pagination and search',
        tags: ['Kelola Pengguna'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaPenggunaRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Data berhasil diambil',
                content: new OA\JsonContent(
                    example: [
                        'success' => true,
                        'message' => 'Data berhasil diambil',
                        'data' => 'data'
                    ]
                )
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Unauthorized'
                    ]
                )
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ]
                )
            )
        ]
    )]


    public function list(Request $request)
    {
        $query = User::with('role');
        $dataTotal = $query->count();

        if ($request->role != '') {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('role_nama', $request->role);
            });
        }

        if ($request->search != '') {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $dataTotal,
            'recordsFiltered' => $query->count(),
            'data' => $query->get()
        ];

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $data
            ]
        );
    }

    #[OA\Get(
        path: '/api/kelola-pengguna/{id}',
        summary: 'Get user detail',
        description: 'Get user detail',
        tags: ['Kelola Pengguna'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID'
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Data berhasil diambil',
                content: new OA\JsonContent(
                    example: [
                        'success' => true,
                        'message' => 'Data berhasil diambil',
                        'data' => 'data'
                    ]
                )
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Unauthorized'
                    ]
                )
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ]
                )
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'User not found'
                    ]
                )
            )
        ]
    )]


    public function detail(Request $request)
    {
        $user = User::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $user
        ]);
    }

    #[OA\Post(
        path: '/api/kelola-pengguna/create',
        summary: 'Create user',
        description: 'Create user',
        tags: ['Kelola Pengguna'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaPenggunaCreateRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Data berhasil ditambahkan',
                content: new OA\JsonContent(
                    example: [
                        'success' => true,
                        'message' => 'Data berhasil ditambahkan',
                        'data' => 'data'
                    ]
                )
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Unauthorized'
                    ]
                )
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Internal Server Error'
                    ]
                )
            )
        ]
    )]

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'username' => 'required',
            'fullname' => 'required',
            'password' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
        ]);
        $hashedPassword = Hash::make($request->password);
        $validatedData['password'] = $hashedPassword;
        $user = User::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $user
        ]);
    }

    #[OA\Put(
        path: '/api/kelola-pengguna/{id}',
        summary: 'Update user',
        description: 'Update user',
        tags: ['Kelola Pengguna'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID'
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaPenggunaUpdateRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Data berhasil diubah',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            )
        ]
    )]

    public function update(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required',
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
        ]);
        $user = User::find($request->id);
        $user->update($validated);
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $user
        ]);
    }

    #[OA\Delete(
        path: '/api/kelola-pengguna/{id}',
        summary: 'Delete user',
        description: 'Delete user',
        tags: ['Kelola Pengguna'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'User ID'
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Data berhasil dihapus',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
            ),
            new OA\Response(
                response: '404',
                description: 'User not found',
            )
        ]
    )]

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

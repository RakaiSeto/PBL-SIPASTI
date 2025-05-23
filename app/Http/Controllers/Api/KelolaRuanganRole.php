<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_ruangan_role as RuanganRole;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Hash;

class KelolaRuanganRole extends Controller
{
    #[OA\Schema(
        schema: 'KelolaRuanganRoleRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'search', type: 'string', example: '')
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaRuanganRoleCreateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'ruangan_role_nama', type: 'string', example: ''),
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaRuanganRoleUpdateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'ruangan_role_nama', type: 'string', example: ''),
        ],
    )]

    #[OA\Post(
        path: '/api/kelola-ruangan-role',
        summary: 'Get list of ruangan role',
        description: 'Get list of ruangan role with pagination and search',
        tags: ['Kelola Ruangan Role'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganRoleRequest')
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
        $query = RuanganRole::with('ruangan');
        $dataTotal = $query->count();

        if ($request->ruangan_role_nama != '') {
            $query->where('ruangan_role_nama', $request->ruangan_role_nama);
        }

        if ($request->search != '') {
            $query->where('ruangan_role_nama', 'like', '%' . $request->search . '%');
        }

        $dataFiltered = $query->count();
        $query->offset($request->start);
        $query->limit($request->length);

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diambil',
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $dataTotal,
                'recordsFiltered' => $dataFiltered,
                'data' => $query->get()
            ]
        );
    }

    #[OA\Get(
        path: '/api/kelola-ruangan-role/{id}',
        summary: 'Get ruangan role detail',
        description: 'Get ruangan role detail',
        tags: ['Kelola Ruangan Role'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Ruangan Role ID'
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
                description: 'Ruangan Role not found',
                content: new OA\JsonContent(
                    example: [
                        'success' => false,
                        'message' => 'Ruangan Role not found'
                    ]
                )
            )
        ]
    )]


    public function detail(Request $request)
    {
        $ruanganRole = RuanganRole::find($request->id);
        if (!$ruanganRole) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan Role not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $ruanganRole
        ]);
    }

    #[OA\Post(
        path: '/api/kelola-ruangan-role/create',
        summary: 'Create ruangan role',
        description: 'Create ruangan role',
        tags: ['Kelola Ruangan Role'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganRoleCreateRequest')
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
            'ruangan_role_nama' => 'required',
        ]);
        $validatedData['created_at'] = now();
        $ruanganRole = RuanganRole::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $ruanganRole
        ]);
    }

    #[OA\Put(
        path: '/api/kelola-ruangan-role/{id}',
        summary: 'Update ruangan role',
        description: 'Update ruangan role',
        tags: ['Kelola Ruangan Role'],
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
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganRoleUpdateRequest')
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
            'ruangan_role_nama' => 'required',
        ]);
        $ruanganRole = RuanganRole::find($request->id);
        if (!$ruanganRole) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan Role not found'
            ], 404);
        }
        $ruanganRole->update($validated);
        $ruanganRole->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $ruanganRole
        ]);
    }

    #[OA\Delete(
        path: '/api/kelola-ruangan-role/{id}',
        summary: 'Delete ruangan role',
        description: 'Delete ruangan role',
        tags: ['Kelola Ruangan Role'],
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
        $ruanganRole = RuanganRole::find($request->id);
        if (!$ruanganRole) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan Role not found'
            ], 404);
        }
        $ruanganRole->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

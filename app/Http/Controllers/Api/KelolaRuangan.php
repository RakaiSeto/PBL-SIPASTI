<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_ruangan as Ruangan;
use OpenApi\Attributes as OA;

class KelolaRuangan extends Controller
{
    #[OA\Schema(
        schema: 'KelolaRuanganRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'lantai', type: 'string', example: ''),
            new OA\Property(property: 'search', type: 'string', example: '')
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaRuanganCreateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'ruangan_role', type: 'string', example: ''),
            new OA\Property(property: 'ruangan_nama', type: 'string', example: ''),
            new OA\Property(property: 'lantai', type: 'string', example: ''),
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaRuanganUpdateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'ruangan_role', type: 'string', example: ''),
            new OA\Property(property: 'ruangan_nama', type: 'string', example: ''),
            new OA\Property(property: 'lantai', type: 'string', example: ''),
        ],
    )]

    #[OA\Post(
        path: '/api/kelola-ruangan',
        summary: 'Get list of ruangan',
        description: 'Get list of ruangan with pagination and search',
        tags: ['Kelola Ruangan'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganRequest')
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
        $query = Ruangan::query();
        $query = $query->with('ruangan_role');
        $dataTotal = $query->count();

        if ($request->lantai != '') {
            $query->where('lantai', $request->lantai);
        }

        if ($request->search != '') {
            $query->where('ruangan_nama', 'like', '%' . $request->search . '%');
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
        path: '/api/kelola-ruangan/{id}',
        summary: 'Get ruangan detail',
        description: 'Get ruangan detail',
        tags: ['Kelola Ruangan'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Ruangan ID'
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
        $ruangan = Ruangan::with('ruangan_role')->find($request->id);
        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $ruangan
        ]);
    }

    #[OA\Post(
        path: '/api/kelola-ruangan/create',
        summary: 'Create ruangan',
        description: 'Create ruangan',
        tags: ['Kelola Ruangan'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganCreateRequest')
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
            'ruangan_role_id' => 'required',
            'ruangan_nama' => 'required',
            'lantai' => 'required',
        ]);
        $ruangan = Ruangan::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $ruangan
        ]);
    }

    #[OA\Put(
        path: '/api/kelola-ruangan/{id}',
        summary: 'Update ruangan',
        description: 'Update ruangan',
        tags: ['Kelola Ruangan'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Ruangan ID'
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaRuanganUpdateRequest')
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
            'ruangan_role_id' => 'required',
            'ruangan_nama' => 'required',
            'lantai' => 'required',
        ]);
        $ruangan = Ruangan::find($request->id);
        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan not found'
            ], 404);
        }
        $ruangan->update($validated);
        $ruangan->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $ruangan
        ]);
    }

    #[OA\Delete(
        path: '/api/kelola-ruangan/{id}',
        summary: 'Delete ruangan',
        description: 'Delete ruangan',
            tags: ['Kelola Ruangan'],
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
        $ruangan = Ruangan::find($request->id);
        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan not found'
            ], 404);
        }
        $ruangan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

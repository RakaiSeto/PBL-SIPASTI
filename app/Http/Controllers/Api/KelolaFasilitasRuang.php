<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_fasilitas_ruang as FasilitasRuangan;
use Illuminate\Support\Collection;
use OpenApi\Attributes as OA;

class KelolaFasilitasRuang extends Controller
{
    #[OA\Schema(
        schema: 'KelolaFasilitasRuangRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'ruangan_id', type: 'string', example: ''),
            new OA\Property(property: 'search', type: 'string', example: '')
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaFasilitasRuangCreateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'fasilitas_id', type: 'string', example: ''),
            new OA\Property(property: 'ruangan_id', type: 'array', example: '[]', items: new OA\Items(type: 'string')),
        ]
    )]

    #[OA\Schema(
        schema: 'KelolaFasilitasRuangUpdateRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'fasilitas_id', type: 'string', example: ''),
            new OA\Property(property: 'ruangan_id', type: 'string', example: ''),
        ],
    )]

    #[OA\Post(
        path: '/api/kelola-fasilitas-ruang',
        summary: 'Get list of fasilitas ruang',
        description: 'Get list of fasilitas ruang with pagination and search',
        tags: ['Kelola Fasilitas Ruang'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaFasilitasRuangRequest')
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
        $dataFiltered = 0;
        $dataTotal = 0;
        $data = new Collection();
        if ($request->ruangan_id != '') {
            $query = FasilitasRuangan::query();
            $query = $query->with('fasilitas', 'ruangan');

            if ($request->ruangan_id != '') {
                $query->whereHas('ruangan', function ($query) use ($request) {
                    $query->where('ruangan_id', $request->ruangan_id);
                });
            }

            if ($request->search != '') {
                $query->whereHas('fasilitas', function ($query) use ($request) {
                    $query->where('fasilitas_nama', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->start != '') {
                $query->skip($request->start);
            }
            if ($request->length != '') {
                $query->take($request->length);
            }
            $data = $query->get();
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diambil',
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $dataTotal,
                'recordsFiltered' => $dataFiltered,
                'data' => $data
            ]
        );
    }

    #[OA\Get(
        path: '/api/kelola-fasilitas-ruang/{id}',
        summary: 'Get fasilitas ruang detail',
        description: 'Get fasilitas ruang detail',
        tags: ['Kelola Fasilitas Ruang'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Fasilitas Ruang ID'
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
        $fasilitas = FasilitasRuangan::with('fasilitas', 'ruangan')->find($request->id);
        if (!$fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas Ruangan not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $fasilitas
        ]);
    }

    #[OA\Post(
        path: '/api/kelola-fasilitas-ruang/create',
        summary: 'Create fasilitas ruang',
        description: 'Create fasilitas ruang',
        tags: ['Kelola Fasilitas Ruang'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaFasilitasRuangCreateRequest')
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
            'ruangan_id' => 'required',
            'fasilitas_id' => 'required|array',
        ]);
        $validatedData['created_at'] = now();
        foreach ($validatedData['fasilitas_id'] as $f) {
            $dataArr = [
                'fasilitas_ruang_id' => 'RU-' . $validatedData['ruangan_id'] . '-' . $f,
                'ruangan_id' => $validatedData['ruangan_id'],
                'fasilitas_id' => $f,
                'created_at' => now()
            ];
            FasilitasRuangan::createOrFirst($dataArr);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    #[OA\Put(
        path: '/api/kelola-fasilitas-ruang/{id}',
        summary: 'Update fasilitas ruang',
        description: 'Update fasilitas ruang',
        tags: ['Kelola Fasilitas Ruang'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Fasilitas Ruang ID'
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/KelolaFasilitasRuangUpdateRequest')
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
            'ruangan_id' => 'required',
            'fasilitas_id' => 'required',
        ]);
        $fasilitas = FasilitasRuangan::find($request->id);
        if (!$fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas Ruangan not found'
            ], 404);
        }
        $fasilitas->update($validated);
        $fasilitas->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $fasilitas
        ]);
    }

    #[OA\Delete(
        path: '/api/kelola-fasilitas-ruang/{id}',
        summary: 'Delete fasilitas ruang',
        description: 'Delete fasilitas ruang',
        tags: ['Kelola Fasilitas Ruang'],
        security: [['cookieAuth' => ['jwtToken']]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Fasilitas Ruang ID'
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
        $fasilitas = FasilitasRuangan::find($request->id);
        if (!$fasilitas) {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas Ruangan not found'
            ], 404);
        }
        $fasilitas->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

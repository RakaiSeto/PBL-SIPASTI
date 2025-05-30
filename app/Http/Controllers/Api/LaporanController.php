<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_laporan;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    #[OA\Schema(
        schema: 'LaporanRequest',
        type: 'object',
        properties: [
            new OA\Property(property: 'lantai', type: 'string', example: ''),
            new OA\Property(property: 'user_id', type: 'string', example: ''),
            new OA\Property(property: 'fasilitas_ruang_id', type: 'string', example: ''),
            new OA\Property(property: 'deskripsi_laporan', type: 'string', example: ''),
            new OA\Property(property: 'lapor_foto', type: 'binary', example: ''),
        ]
    )]

    #[OA\Post(
        path: '/api/laporkan',
        summary: 'Laporan',
        description: 'Laporan',
        tags: ['Laporan'],
        security: [['cookieAuth' => ['jwtToken']]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/LaporanRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Laporan berhasil dikirim',
            ),
            new OA\Response(
                response: '401',
                description: 'Unauthorized',
            ),
            new OA\Response(
                response: '500',
                description: 'Internal Server Error',
            ),
        ]
    )]
    public function store(Request $request)
    {
        $reqData = $request->all();
        $rules = [
            'fasilitas_ruang_id' => 'required',
            'deskripsi_laporan' => 'required',
            'lapor_foto' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $laporan = new t_laporan();
        $laporan->user_id = auth()->user()->user_id;
        $laporan->fasilitas_ruang_id = $request->fasilitas_ruang_id;
        $laporan->deskripsi_laporan = $request->deskripsi_laporan;
        $laporan->lapor_foto = $request->file('lapor_foto')->getContent();
        $laporan->lapor_datetime = now();
        $laporan->is_verified = 0;
        $laporan->is_done = 0;
        $laporan->save();

        return response()->json([
            'message' => 'Laporan berhasil dikirim',
            'data' => $laporan->laporan_id
        ]);
    }
}

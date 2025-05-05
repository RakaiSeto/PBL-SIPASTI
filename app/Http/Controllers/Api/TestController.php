<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;


#[OA\Info(
    version: '1.0.0',
    title: 'Test API',
    description: 'Test API'
)]

#[OA\Get(
    path: '/api/test',
    operationId: 'getData',
    tags: ['Test'],
    responses: [
        new OA\Response(
            response: '200',
            description: 'The data'
        )
    ]
)]

class TestController extends Controller
{
    
    public function __invoke()
    {   
        return response()->json([
            'message' => 'Hello World'
        ]);
    }
}

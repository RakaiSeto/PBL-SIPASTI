<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __invoke()
    {   
        return response()->json([
            'message' => 'Hello World'
        ]);
    }
}

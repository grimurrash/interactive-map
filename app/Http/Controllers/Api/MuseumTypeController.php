<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MuseumType;

class MuseumTypeController extends Controller
{
    public function index()
    {
        $museumsTypes = MuseumType::all();
        return response()->json([
            'types' => $museumsTypes
        ])->setStatusCode(200);
    }
}

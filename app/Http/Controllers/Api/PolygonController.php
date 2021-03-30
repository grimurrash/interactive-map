<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Polygon;

class PolygonController extends Controller
{
    public function index()
    {
        $polygons = Polygon::all();
        return response()->json([
            'polygons' => $polygons
        ])->setStatusCode(200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MuseumType;
use App\Models\Polygon;

class SettingController extends Controller
{
    public function index() {
        $polygons = Polygon::all();
        $museumsTypes = MuseumType::all();

        return response()->json([
            'polygons' => $polygons,
            'museumsTypes' =>$museumsTypes
        ])->setStatusCode(200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubjectType;
use App\Models\Polygon;

class SettingController extends Controller
{
    public function index() {
        $polygons = Polygon::all();
        $subjectTypes = SubjectType::all();

        return response()->json([
            'polygons' => $polygons,
            'subjectTypes' => $subjectTypes
        ])->setStatusCode(200);
    }
}

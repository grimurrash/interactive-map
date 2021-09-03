<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubjectType;

class SubjectTypeController extends Controller
{
    public function index()
    {
        $subjectTypes = SubjectType::all();
        return response()->json([
            'types' => $subjectTypes
        ])->setStatusCode(200);
    }
}

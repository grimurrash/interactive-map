<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Models\Polygon;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $typeIdsString = $request->input('subjectTypeIds');
        $districtId = $request->input('districtId');
        if (!empty($typeIdsString)) {
            $typeIds = explode(',', $typeIdsString);
            $subjects = Subject::query()
                ->where('districtId', '=', $districtId)
                ->whereIn('typeId', $typeIds)
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        } else {
            $subjects = Subject::query()
                ->where('districtId', '=', $districtId)
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        }
        $polygonIds = Polygon::query()->where('districtId', '=', $districtId)
            ->select('id')->get()->map(function ($polygon) {
                return $polygon->id;
            });
        return response()->json([
            'district' => [
                'id' => $districtId,
                'points' => $subjects,
                'polygons' => $polygonIds
            ],
        ])->setStatusCode(200);
    }

    public function show(Request $request)
    {
        $subjectId = $request->input('subjectId');
        $subject = Subject::query()->find($subjectId);
        return response()->json([
            'subject' => new SubjectResource($subject)
        ])->setStatusCode(200);
    }

    public function search(Request $request)
    {
        $typeIdsString = $request->input('subjectTypeIds');
        $search = $request->input('search');

        if (empty($typeIdsString)) {
            $subjects = Subject::query()
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search")
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        } else {
            $typeIds = explode(',', $typeIdsString);
            $subjects = Subject::query()
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search")
                ->whereIn('typeId', $typeIds)
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        }

        return response()->json([
            'search' => $subjects,
        ])->setStatusCode(200);
    }
}

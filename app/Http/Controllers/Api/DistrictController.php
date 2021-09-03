<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $typeIdsString = $request->input('subjectTypeIds');
        if (empty($typeIdsString)) {
            $districts = District::query()
                ->join('subjects', 'districts.id', '=', 'subjects.districtId')
                ->selectRaw('districts.id, districts.shortName, count(subjects.id) as subjectsCount, districts.Latitude, districts.Longitude')
                ->groupBy('districts.id')
                ->get();
        } else {
            $typeIds = explode(',', $typeIdsString);
            $districts = District::query()
                ->join('subjects', 'districts.id', '=', 'subjects.districtId')
                ->whereIn('subjects.typeId', $typeIds)
                ->selectRaw('districts.id, districts.shortName, count(subjects.id) as subjectsCount, districts.Latitude, districts.Longitude')
                ->groupBy('districts.id')
                ->get();
        }
        return response()->json([
            'points' => $districts,
            'districts' => DistrictResource::collection($districts)
        ])->setStatusCode(200);
    }
}

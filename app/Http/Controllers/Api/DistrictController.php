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
        $typeIdsString = $request->input('museumTypeIds');
        if (empty($typeIdsString)) {
            $districts = District::query()
                ->join('museums', 'districts.id', '=', 'museums.districtId')
                ->selectRaw('districts.id, districts.shortName, count(museums.id) as museumsCount, districts.Latitude, districts.Longitude')
                ->groupBy('districts.id')
                ->get();
        } else {
            $typeIds = explode(',', $typeIdsString);
            $districts = District::query()
                ->join('museums', 'districts.id', '=', 'museums.districtId')
                ->whereIn('museums.typeId', $typeIds)
                ->selectRaw('districts.id, districts.shortName, count(museums.id) as museumsCount, districts.Latitude, districts.Longitude')
                ->groupBy('districts.id')
                ->get();
        }
        return response()->json([
            'points' => $districts,
            'districts' => DistrictResource::collection($districts)
        ])->setStatusCode(200);
    }
}

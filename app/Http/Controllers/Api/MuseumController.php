<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MuseumResource;
use App\Http\Resources\MuseumsResource;
use App\Models\District;
use App\Models\Museum;
use App\Models\Polygon;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index(Request $request)
    {
        $typeIdsString = $request->input('museumTypeIds');
        $districtId = $request->input('districtId');
        $district = District::query()->find($districtId);
        $museums = $district->museums;
        if (!empty($typeIdsString)) {
            $typeIds = explode(',', $typeIdsString);
            $museums = $museums->whereIn('typeId', $typeIds);
        }

        return response()->json([
            'district' => [
                'id' => $districtId,
                'points' => MuseumsResource::collection($museums),
                'polygons' => $district->polygons->map(function ($polygon) {
                    return $polygon->id;
                })
            ],
        ])->setStatusCode(200);
    }

    public function show(Request $request)
    {
        $museumId = $request->input('museumId');
        $museum = Museum::query()->find($museumId);
        return response()->json([
            'museum' => new MuseumResource($museum)
        ])->setStatusCode(200);
    }

    public function search(Request $request)
    {
        $typeIdsString = $request->input('museumTypeIds');
        $search = $request->input('search');

        if (empty($typeIdsString)) {
            $museums = Museum::query()
                ->where('name', 'LIKE', "%$search%")
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        } else {
            $typeIds = explode(',', $typeIdsString);
            $museums = Museum::query()
                ->where('name', 'LIKE', "%$search%")
                ->whereIn('typeId', $typeIds)
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        }

        return response()->json([
            'search' => $museums,
        ])->setStatusCode(200);
    }
}

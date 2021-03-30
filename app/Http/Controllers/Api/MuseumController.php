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
        if (!empty($typeIdsString)) {
            $typeIds = explode(',', $typeIdsString);
            $museums = Museum::query()
                ->where('districtId', '=', $districtId)
                ->whereIn('typeId', $typeIds)
                ->select('id','name','typeId','districtId','Latitude', 'Longitude')
                ->get();
        } else {
            $museums = Museum::query()
                ->where('districtId', '=', $districtId)
                ->select('id','name','typeId','districtId','Latitude', 'Longitude')
                ->get();
        }
        $polygons = Polygon::query()->where('districtId','=',$districtId)
            ->select('id')->get();
        $polygonIds = $polygons->map(function ($polygon) {
            return $polygon->id;
        });
        return response()->json([
            'district' => [
                'id' => $districtId,
                'points' => $museums,
                'polygons' => $polygonIds
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
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('location','LIKE',"%$search")
                ->orWhere('description','LIKE',"%$search")
                ->orWhere('directorFio','LIKE',"%$search")
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        } else {
            $typeIds = explode(',', $typeIdsString);
            $museums = Museum::query()
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('location','LIKE',"%$search")
                ->orWhere('description','LIKE',"%$search")
                ->orWhere('directorFio','LIKE',"%$search")
                ->whereIn('typeId', $typeIds)
                ->select('id', 'name', 'typeId', 'districtId', 'Latitude', 'Longitude')
                ->get();
        }

        return response()->json([
            'search' => $museums,
        ])->setStatusCode(200);
    }
}

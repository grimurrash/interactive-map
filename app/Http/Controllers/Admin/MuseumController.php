<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminMuseumsResource;
use App\Models\District;
use App\Models\Museum;
use App\Models\MuseumType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yajra\Datatables\DataTables;

class MuseumController extends Controller
{
    public function index()
    {
        $districts = District::all();
        $museumTypes = MuseumType::all();
        return view('admin.museums.index', compact('districts', 'museumTypes'));
    }

    public function indexData()
    {
        $museums = Museum::query()
            ->select('id', 'name', 'code', 'name', 'typeId', 'districtId', 'description')->get();
        return DataTables::of(AdminMuseumsResource::collection($museums))
            ->addColumn('action', function () {
                return '
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 delete align-middle mt-3"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>                
                ';
            })
            ->make(true);
    }

    public function create()
    {
        $districts = District::all();
        $museumTypes = MuseumType::all();
        return view('admin.museums.create', compact('districts', 'museumTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'code' => ['required', 'numeric'],
            'typeId' => ['required', 'numeric'],
            'districtId' => ['required', 'numeric'],
            'Latitude' => ['required', 'regex:/^\b(54|55|56|57)\b(\.\d{0,10})?$/'],
            'Longitude' => ['required', 'regex: /^\b(36|37|38|39)\b(\.\d{0,10})?$/'],
            'address' => 'max:255',
            'location' => 'max:255',
            'website' => 'max:255',
            'phone' => 'max:255',
            'email' => 'max:255',
            'founderFIO' => 'max:255',
            'createDate' => 'max:255',
            'directorFio' => 'max:255',
            'directorPhone' => 'max:255',
            'directorEmail' => 'max:255',
        ], [
            'name.required' => 'Введите наименование музея',
            'name.max' => 'Ваше наименование музея слишком длинное',
            'code.required' => 'Введите код в реестре',
            'code.numeric' => 'Код в реестре должен быть числом',
            'Latitude.required' => 'Введите координаты (Широта) музея',
            'Latitude.regex' => 'Широта должна быть в диапозоне от 54 до 57',
            'Longitude.required' => 'Введите координаты (Долгота) музея',
            'Longitude.regex' => 'Долгота должна быть в диапозоне от 36 до 39',
            'districtId.required' => 'Введите административный округ',
            'address.max' => 'Ваш адрес слишком длинный',
            'location.max' => 'Ваше наименование школы слишком длинное',
            'website.max' => 'Ваш адрес сайт слишком длинный',
            'phone.max' => 'Ваш номер телефона слишком длинный',
            'email.max' => 'Ваш электронный адрес слишком длинный',
            'founderFIO.max' => 'Ваш ФИО основателя слишком длинный',
            'createDate.max' => 'Ваша дата основания слишком длинный',
            'directorFio.max' => 'Ваш ФИО руководителя музея слишком длинный',
            'directorPhone.max' => 'Ваш телефон руководителя музея слишком длинный',
            'directorEmail.max' => 'Ваш электронный адрес руководителя музея слишком длинный',
        ]);
        $form = $request->all();

        Museum::create([
            'name' => $form['name'],
            'description' => $form['description'] ?? "",
            'typeId' => $form['typeId'],
            'districtId' => $form['districtId'],
            'code' => $form['code'],
            'Latitude' => $form['Latitude'],
            'Longitude' => $form['Longitude'],
            'address' => $form['address'] ?? "",
            'location' => $form['location'] ?? "",
            'website' => $form['website'] ?? "",
            'phone' => $form['phone'] ?? "",
            'email' => $form['email'] ?? "",
            'imagesUrlStr' => $form['imagesUrlStr'] ?? '',
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
            'directorFio' => $form['directorFio'] ?? "",
            'directorPhone' => $form['directorPhone'] ?? "",
            'directorEmail' => $form['directorEmail'] ?? "",
        ]);
        return redirect()->route('admin.museums.index');
    }

    public function edit(Museum $museum): JsonResponse
    {
        return response()->json([
            'museum' => $museum
        ]);
    }

    public function update(Request $request, Museum $museum): JsonResponse
    {
        $form = $request->all();
        $updateMuseum = [
            'name' => $form['name'],
            'description' => $form['description'] ?? "",
            'typeId' => $form['typeId'],
            'districtId' => $form['districtId'],
            'address' => $form['address'] ?? "",
            'location' => $form['location'] ?? "",
            'website' => $form['website'] ?? "",
            'phone' => $form['phone'] ?? "",
            'email' => $form['email'] ?? "",
            'imagesUrlStr' => $form['imagesUrlStr'] ?? '',
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
            'directorFio' => $form['directorFio'] ?? "",
            'directorPhone' => $form['directorPhone'] ?? "",
            'directorEmail' => $form['directorEmail'] ?? "",
        ];
        $museum->update($updateMuseum);
        return response()->json(['status' => true]);
    }

    public function destroy(Museum $museum): JsonResponse
    {
        $museum->delete();
        return response()->json(['status' => true]);
    }

    public function importFromExcel(Request $request)
    {
        $storageDir = storage_path('app');

        $loadFile = $request->file('file');
        $loadFileName = 'loadDataFile.' . $loadFile->getClientOriginalExtension();
        Storage::put($loadFileName, file_get_contents($loadFile->getRealPath()));
        $loadFilePath = $storageDir . '/' . $loadFileName;

        $excel = IOFactory::load($loadFilePath);
        $worksheet = $excel->getActiveSheet();
        $loadDataList = $worksheet->toArray();
        unset($excel);
        unlink($loadFilePath);

        $districts = District::all();
        $types = MuseumType::all();

        $insertData = [];
        foreach ($loadDataList as $index => $row) {
            if ($index < 3) continue;

            try {
                $coordination = explode(',', $row[15]);
                $lat = trim($coordination[0]);
                $lon = trim($coordination[1]);

//                $imageUrlStr = "";
//                if (isset($row[23]))
//                    $imageUrlStr .= trim($row[23]) . "\r\n";
//                if (isset($row[24]))
//                    $imageUrlStr .= trim($row[23]) . "\r\n";
//                if (isset($row[25]))
//                    $imageUrlStr .= trim($row[25]);

                $address = $row[14];
                $geoData = DaDataAddress::geolocate($lat, $lon, 1, 50, Language::RU);
                if (isset($geoData['suggestions'][0]))
                    $address = $geoData['suggestions'][0]['unrestricted_value'];
                $insertData[] = [
                    'name' => trim($row[13]),
                    'description' => trim($row[18] ?? ""),
                    'typeId' => $types->where('name', '=', $row[17])->first()->id,
                    'districtId' => $districts->where('shortName', '=', $row[16])->first()->id,
                    'code' => trim($row[1]),
                    'Latitude' => $lat,
                    'Longitude' => $lon,
                    'address' => $address ?? "",
                    'location' => trim($row[3] ?? ""),
                    'website' => $row[19] ?? "",
                    'imagesUrlStr' => '',
                    'phone' => "",
                    'email' => "",
                    'founderFIO' => "",
                    'createDate' => "",
                    'directorFio' => trim($row[20] ?? ""),
                    'directorPhone' => trim($row[22] ?? ""),
                    'directorEmail' => trim($row[21] ?? ""),
                ];
            } catch (\Exception $e) {
                dd($row, $e);
            }

        }
//        dd($insertData);
        Museum::query()->insert($insertData);
        return response()->json(['status' => true]);
    }
}

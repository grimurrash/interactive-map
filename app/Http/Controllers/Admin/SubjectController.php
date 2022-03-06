<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminSubjectsResource;
use App\Models\District;
use App\Models\Subject;
use App\Models\SubjectType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yajra\Datatables\DataTables;

class SubjectController extends Controller
{
    public function index()
    {
        $districts = District::all();
        $subjectTypes = SubjectType::all();
        return view('admin.subjects.index', compact('districts', 'subjectTypes'));
    }

    /**
     * @throws Exception
     */
    public function indexData()
    {
        $subjects = Subject::query()
            ->select('id', 'name', 'typeId', 'districtId', 'description')->get();
        return DataTables::of(AdminSubjectsResource::collection($subjects))
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
        $subjectTypes = SubjectType::all();
        return view('admin.subjects.create', compact('districts', 'subjectTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'typeId' => ['required', 'numeric'],
            'districtId' => ['required', 'numeric'],
            'Latitude' => ['required', 'regex:/^\b(54|55|56|57)\b(\.\d{0,10})?$/'],
            'Longitude' => ['required', 'regex: /^\b(36|37|38|39)\b(\.\d{0,10})?$/'],
            'address' => 'max:255',
        ], [
            'name.required' => 'Введите наименование музея',
            'name.max' => 'Ваше наименование музея слишком длинное',
            'Latitude.required' => 'Введите координаты (Широта) музея',
            'Latitude.regex' => 'Широта должна быть в диапозоне от 54 до 57',
            'Longitude.required' => 'Введите координаты (Долгота) музея',
            'Longitude.regex' => 'Долгота должна быть в диапозоне от 36 до 39',
            'districtId.required' => 'Введите административный округ',
            'address.max' => 'Ваш адрес слишком длинный',
        ]);
        $form = $request->all();
        Subject::query()->create([
            'name' => $form['name'],
            'description' => $form['description'] ?? "",
            'typeId' => 1,
            'districtId' => $form['districtId'],
            'Latitude' => $form['Latitude'],
            'imagesUrlStr' => $form['imagesUrlStr'] ?? '',
            'Longitude' => $form['Longitude'],
            'address' => $form['address'] ?? "",
        ]);
        return redirect()->route('admin.subjects.index');
    }

    public function edit(Subject $subject)
    {
        return response()->json([
            'subject' => $subject
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $form = $request->all();
        $updateSubject = [
            'name' => $form['name'],
            'description' => $form['description'] ?? "",
            'typeId' => $form['typeId'],
            'imagesUrlStr' => $form['imagesUrlStr'] ?? '',
            'districtId' => $form['districtId'],
            'address' => $form['address'] ?? "",
        ];
        $subject->update($updateSubject);
        return response()->json(['status' => true]);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

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

        $insertData = [];
        foreach ($loadDataList as $index => $row) {
            if ($index < 2) continue;

            if ($row[2] == null || $row[2] == '' || $row[6] == null || $row[6] == '') continue;
            try {
                $coordination = explode(',', str_replace("\n", '', $row[5]));
                $lat = trim($coordination[0]);
                $lon = trim($coordination[1]);

                $type = SubjectType::where('name', '=', trim($row[2]))->first();
                if ($type == null) {
                    $type = SubjectType::query()->create([
                        'name' => trim($row[2]),
                        'color' => ''
                    ]);
                }

                $address = $row[4];
                $geoData = DaDataAddress::geolocate($lat, $lon, 1, 50, Language::RU);
                if (isset($geoData['suggestions'][0]))
                    $address = $geoData['suggestions'][0]['unrestricted_value'];

                $insertData[] = [
                    'name' => trim($row[3]),
                    'description' => trim($row[7] ?? ""),
                    'typeId' => $type->id,
                    'districtId' => $districts->where('shortName', '=', $row[6])->first()->id,
                    'Latitude' => $lat,
                    'Longitude' => $lon,
                    'address' => $address ?? "",
                    'imagesUrlStr' => $row[8] ?? ''
                ];
            } catch (\TypeError | \Exception $e) {
                dd($row, $e);
            }

        }
        Subject::query()->insert($insertData);
        return response()->json(['status' => true]);
    }
}

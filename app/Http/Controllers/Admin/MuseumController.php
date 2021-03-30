<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminMuseumsResource;
use App\Models\District;
use App\Models\Museum;
use App\Models\MuseumType;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $form = $request->all();
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
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
            'directorFio' => $form['directorFio'] ?? "",
            'directorPhone' => $form['directorPhone'] ?? "",
            'directorEmail' => $form['directorEmail'] ?? "",
        ]);
        return redirect()->route('admin.museums.index');
    }

    public function edit(Museum $museum)
    {
        return response()->json([
            'museum' => $museum
        ])->setStatusCode(200);
    }

    public function update(Request $request, Museum $museum)
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
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
            'directorFio' => $form['directorFio'] ?? "",
            'directorPhone' => $form['directorPhone'] ?? "",
            'directorEmail' => $form['directorEmail'] ?? "",
        ];
        $museum->update($updateMuseum);
        return response()->json(['status' => true])->setStatusCode(200);
    }
}

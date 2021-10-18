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
        $museums = Subject::query()
            ->select('id', 'name', 'typeId', 'districtId', 'description')->get();
        return DataTables::of(AdminSubjectsResource::collection($museums))
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
            'districtId' => ['required', 'numeric'],
            'Latitude' => ['required', 'regex:/^\b(54|55|56|57)\b(\.\d{0,10})?$/'],
            'Longitude' => ['required', 'regex: /^\b(36|37|38|39)\b(\.\d{0,10})?$/'],
            'address' => 'max:255',
            'website' => 'max:255',
            'founderFIO' => 'max:255',
            'createDate' => 'max:255',
        ], [
            'name.required' => 'Введите наименование музея',
            'name.max' => 'Ваше наименование музея слишком длинное',
            'Latitude.required' => 'Введите координаты (Широта) музея',
            'Latitude.regex' => 'Широта должна быть в диапозоне от 54 до 57',
            'Longitude.required' => 'Введите координаты (Долгота) музея',
            'Longitude.regex' => 'Долгота должна быть в диапозоне от 36 до 39',
            'districtId.required' => 'Введите административный округ',
            'address.max' => 'Ваш адрес слишком длинный',
            'website.max' => 'Ваш адрес сайт слишком длинный',
            'founderFIO.max' => 'Ваш ФИО основателя слишком длинный',
            'createDate.max' => 'Ваша дата основания слишком длинный',
        ]);
        $form = $request->all();
        Subject::query()->create([
            'name' => $form['name'],
            'description' => $form['description'] ?? "",
            'typeId' => 1,
            'districtId' => $form['districtId'],
            'Latitude' => $form['Latitude'],
            'Longitude' => $form['Longitude'],
            'address' => $form['address'] ?? "",
            'website' => $form['website'] ?? "",
            'video' => ($form['video'] ? str_replace('/watch?v=', '/embed/', $form['video']) : ''),
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
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
//            'typeId' => $form['typeId'],
            'districtId' => $form['districtId'],
            'address' => $form['address'] ?? "",
            'website' => $form['website'] ?? "",
            'video' => ($form['video'] ? str_replace('/watch?v=', '/embed/', $form['video']) : ''),
            'founderFIO' => $form['founderFIO'] ?? "",
            'createDate' => $form['createDate'] ?? "",
        ];
        $subject->update($updateSubject);
        return response()->json(['status' => true]);
    }

    public function destroy(Subject  $subject)
    {
        $subject->delete();

        return response()->json(['status'=> true]);
    }
}

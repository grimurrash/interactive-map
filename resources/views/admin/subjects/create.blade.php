@extends('admin.layouts.app')

@section('content')
    <h3 class="h3 mb-3">Добавление объекта</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="edit-form" method="POST" action="{{ route('admin.subjects.store') }}"
                          class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-3 col-form-label text-sm-end">Название объекта</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Название объекта" class="form-control" id="name"
                                       name="name" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-sm-3 col-form-label text-sm-end">Описание</label>
                            <div class="col-sm-8">
                                <textarea placeholder="Историческая справка (кратко)" class="form-control" rows="5"
                                          name="description"
                                          id="description"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="mb-3 row">--}}
{{--                            <label for="typeId" class="col-sm-3 col-form-label text-sm-end">Категория музея</label>--}}
{{--                            <div class="col-sm-8">--}}
{{--                                <select name="typeId" id="typeId" required class="form-select">--}}
{{--                                    @foreach($museumTypes as $type)--}}
{{--                                        <option value="{{ $type->id }}">{{ $type->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('typeId')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="mb-3 row">
                            <label for="districtId" class="col-sm-3 col-form-label text-sm-end">Округ</label>
                            <div class="col-sm-8">
                                <select name="districtId" required id="districtId"
                                        class="form-select">
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                @error('districtId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Latitude" class="col-sm-3 col-form-label text-sm-end">GPS координаты</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" placeholder="Широта (54-57)" class="form-control"
                                           id="Latitude" name="Latitude" required>
                                    <input type="text" placeholder="Долгота (36-39)" class="form-control"
                                           id="Longitude" name="Longitude" required>
                                </div>
                                @error('Latitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @error('Longitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="address" class="col-sm-3 col-form-label text-sm-end">Фактический адрес</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Фактический адрес (необязательно)" class="form-control"
                                       id="address" name="address">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="website" class="col-sm-3 col-form-label text-sm-end">Сайт объекта</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Сайт объекта (необязательно)" class="form-control"
                                       id="website" name="website">
                                @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="video" class="col-sm-3 col-form-label text-sm-end">Видео</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Название объекта" class="form-control" id="video"
                                       name="video" required>
                                @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="founderFIO" class="col-sm-3 col-form-label text-sm-end">Основатель (ФИО)</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Основатель (ФИО) (необязательно)" class="form-control"
                                       id="founderFIO" name="founderFIO">
                                @error('founderFIO')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="createDate" class="col-sm-3 col-form-label text-sm-end">Дата открытия</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Дата открытия (необязательно)"
                                       class="form-control" id="createDate" name="createDate">
                                @error('createDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div class="ms-sm-auto text-center">
                                <button class="btn btn-primary btn-lg" type="submit">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('admin.layouts.app')

@section('content')
    <h3 class="h3 mb-3">Добавление музея</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="edit-form" method="POST" action="{{ route('admin.museums.store') }}"
                          class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3 row">
                            <label for="code" class="col-sm-3 col-form-label text-sm-end">Код в реестре</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Код в реестре" class="form-control" id="code"
                                       name="code">
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-3 col-form-label text-sm-end">Название музея</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Название музея" class="form-control" id="name"
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
                        <div class="mb-3 row">
                            <label for="typeId" class="col-sm-3 col-form-label text-sm-end">Категория музея</label>
                            <div class="col-sm-8">
                                <select name="typeId" id="typeId" required class="form-select">
                                    @foreach($museumTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('typeId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
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
                            <label for="location" class="col-sm-3 col-form-label text-sm-end">Школа</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Школа (необязательно)" class="form-control"
                                       id="location" name="location">
                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="website" class="col-sm-3 col-form-label text-sm-end">Сайт музея</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Сайт музея (необязательно)" class="form-control"
                                       id="website" name="website">
                                @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phone" class="col-sm-3 col-form-label text-sm-end">Телефон музея</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Телефон музея (необязательно)" class="form-control"
                                       id="phone" name="phone">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label text-sm-end">Электроная почта</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Электроная почта (необязательно)" class="form-control"
                                       id="email" name="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="imagesUrlStr" class="col-sm-3 col-form-label text-sm-end">Ссылки на фото</label>
                            <div class="col-sm-8">
                                <textarea placeholder="Ссылки на фото (Каждая фотография новая строка)"
                                          class="form-control" rows="3" name="imagesUrlStr"
                                          id="imagesUrlStr"></textarea>
                                @error('imagesUrlStr')
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
                            <label for="createDate" class="col-sm-3 col-form-label text-sm-end">Дата создания
                                музея</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Дата создания музея (необязательно)"
                                       class="form-control" id="createDate" name="createDate">
                                @error('createDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label for="directorFio" class="col-sm-3 col-form-label text-sm-end">Руководитель музея
                                (ФИО)</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Руководитель музея (ФИО) (необязательно)"
                                       class="form-control" id="directorFio" name="directorFio">
                                @error('directorFio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="directorPhone" class="col-sm-3 col-form-label text-sm-end">Руководитель музея
                                (телефон)</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Руководитель музея (телефон) (необязательно)"
                                       class="form-control" id="directorPhone" name="directorPhone">
                                @error('directorPhone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="directorEmail" class="col-sm-3 col-form-label text-sm-end">Руководитель музея
                                (email)</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       placeholder="Руководитель музея (адрес электронной почты) (необязательно)"
                                       class="form-control" id="directorEmail" name="directorEmail">
                                @error('directorEmail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
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


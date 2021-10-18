@extends('admin.layouts.app')

@section('content')
    <h3 class="h3 mb-3">Список объектов волонтеров</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="subjects-table" class="table align-" style="width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название объекта</th>
{{--                            <th scope="col">Тип объекта</th>--}}
                            <th scope="col">Округ</th>
                            <th scope="col">Историческая справка (кратко)</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/datatables.js') }}"></script>
    <script>

        function btnSubmitEditForm() {
            $('#edit-form').submit()
        }

        function formTemplate(d) {
            // `d` is the original data object for the row
            return `
<div class="col-sm-12">
    <div class="card" style="box-shadow: 0px 0px 0.875rem 0 rgb(34 38 41 / 20%)">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <h5 class="card-title">Редактирование</h5>
                </div>
                <div class="col-sm-4 text-end">
                    <button class="btn btn-primary ml-4" onclick="btnSubmitEditForm()" type="button">Сохранить</button>
                    <button class="btn btn-outline-secondary btn-form-close" type="button">Закрыть</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="edit-form" action="/admin/subjects/${d.id}/update" onsubmit="submitEditForm(event)" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3 row">
                    <label for="name" class="col-sm-3 col-form-label text-sm-end">Название объекта</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Название объекта" req class="form-control" id="name" name="name"
                               value="${d.name}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="description" class="col-sm-3 col-form-label text-sm-end">Историческая справка (кратко)</label>
                    <div class="col-sm-8">
                        <textarea placeholder="Историческая справка (кратко)" class="form-control" rows="5"
                                  name="description"
                                  id="description">${d.description}
                        </textarea>
                    </div>
                </div>
                {{--<div class="mb-3 row">--}}
                {{--    <label for="typeId" class="col-sm-3 col-form-label text-sm-end">Категория музея</label>--}}
                {{--    <div class="col-sm-8">--}}
                {{--        <select name="typeId" value="${d.typeId}" id="typeId" required class="form-select">--}}
                {{--            @foreach($subjectsTypes as $type)--}}
                {{--            <option value="{{ $type->id }}">{{ $type->name }}</option>--}}
                {{--            @endforeach--}}
                {{--        </select>--}}
                {{--    </div>--}}
                {{--</div>--}}
                <div class="mb-3 row">
                    <label for="districtId" class="col-sm-3 col-form-label text-sm-end">Округ</label>
                    <div class="col-sm-8">
                        <select name="districtId" value="${d.districtId}" required id="districtId" class="form-select">
                                        @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="address" class="col-sm-3 col-form-label text-sm-end">Фактический адрес</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Фактический адрес (необязательно)" class="form-control"
                               id="address"
                               name="address" value="${d.address}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="website" class="col-sm-3 col-form-label text-sm-end">Сайт объекта</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Сайт объекта (необязательно)" class="form-control" id="website"
                               name="website" value="${d.website}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="video" class="col-sm-3 col-form-label text-sm-end">Видео</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Видео" req class="form-control" id="video" name="video"
                               value="${d.video}" required>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label for="founderFIO" class="col-sm-3 col-form-label text-sm-end">Основатель (ФИО)</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Основатель (ФИО) (необязательно)" class="form-control"
                               id="founderFIO"
                               name="founderFIO" value="${d.founderFIO}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="createDate" class="col-sm-3 col-form-label text-sm-end">Дата создания музея</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="Дата открытия (необязательно)" class="form-control"
                               id="createDate"
                               name="createDate" value="${d.createDate}">
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label for="Latitude" class="col-sm-3 col-form-label text-sm-end">GPS координаты</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" placeholder="Широта (54-57)" class="form-control" id="Latitude"
                                   name="Latitude" value="${d.Latitude}" disabled>
                            <input type="text" placeholder="Долгота (36-39)" class="form-control" id="Longitude"
                                   name="Longitude" value="${d.Longitude}" disabled>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-sm-10 ms-sm-auto">
                        <button class="btn btn-primary" onclick="btnSubmitEditForm()" type="button">Сохранить</button>
                        <button class="btn btn-outline-secondary btn-form-close" type="button">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>`;
        }


        function submitEditForm(e) {
            e.preventDefault()
            let form = $('#edit-form');
            let url = form.attr('action')

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (data) {
                    if (data.status) {
                        $("#btn-form-close").click()
                        table.ajax.reload()
                    }
                }
            });
        }

        var table = $('#subjects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.subjects.datatables') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                // {data: 'type', name: 'type'},
                {data: 'district', name: 'district'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'table-action'}
            ]
        })

        $('#subjects-table tbody').on('click', 'td.table-action .feather-edit-2', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                fetch(`/admin/subjects/${row.data().id}/edit`)
                    .then(res => res.json())
                    .then(data => {
                        // Open this row
                        row.child(formTemplate(data.subject)).show();

                        // const selectTypeId = document.querySelector('#typeId').getElementsByTagName('option');
                        // for (let i = 0; i < selectTypeId.length; i++) {
                        //     if (selectTypeId[i].value == data.subject.typeId) selectTypeId[i].selected = true;
                        // }

                        const selectDistrictId = document.querySelector('#districtId').getElementsByTagName('option');
                        for (let i = 0; i < selectDistrictId.length; i++) {
                            if (parseInt(selectDistrictId[i].value) === parseInt(data.subject.districtId)) selectDistrictId[i].selected = true;
                        }

                        $(".btn-form-close").on('click',() => {
                            row.child.hide();
                            $("html,body").scrollTop($(this).offset().top - 150);
                            tr.removeClass('shown');
                        })
                        tr.addClass('shown');
                    })
            }
        });
        $('#subjects-table tbody').on('click', 'td.table-action .delete', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            fetch(`/admin/subjects/${row.data().id}/delete`)
                .then(() => {
                    table.ajax.reload()
                })
        })
    </script>
@endpush

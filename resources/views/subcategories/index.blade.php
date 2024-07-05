@extends('layout.baselayot')


@section('content')
    <h1>Подкатегории</h1>
    <div class="accordion card">
        <div class="card-body">
            <p class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Добавление новой
                    подкатегории</button></p>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label">Название подкатегории</label>
                        <input class="form-control" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label" for="description">Описание подкатегории </label>
                        <input class="form-control" type="text" name="description" placeholder="Description">
                    </div>
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label" for="slug">ярлычок подкатегории (краткое описание которое отличает
                            данную
                            подкатегорию)</label>
                        <input class="form-control" type="text" name="slug" placeholder="Slug">
                    </div>
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label">Картинка подкатегории</label>
                        <input class="form-control" type="file" name="image" id="image" placeholder="Image">
                    </div>
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label">Иконка подкатегории</label>
                        <input class="form-control" type="file" name="icon" id="icon" placeholder="Icon">
                    </div>
                    <div class="mt-3 border-bottom pb-3">
                        <label class="form-label">Категория к которой относится подкатегория <span
                                class="text-danger">*</span></label>
                        <select class="form-select" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary mt-3" type="submit">Create</button>
                    @if ($errors->all())
                        @foreach ($errors->all() as $error)
                            <div style="color: red">{{ $error }}</div>
                        @endforeach
                    @endif
                </form>
            </div>
        </div>
    </div>
    @if ($subcategories->count() > 0)
        <table class="table table-bordered border-grey mt-5">
            <tr>
                <th>Название подкатегории</th>
                <th>Описание</th>
                <th>Слауг</th>
                <th>Картинка</th>
                <th>Иконка</th>
                <th>Категория</th>
                <th>
                    удалить
                </th>
                <th>Редактировать</th>
            </tr>
            @foreach ($subcategories as $subcategory)
                <tr>
                    <th>{{ $subcategory->name }}</th>
                    <th>{{ $subcategory->description }}</th>
                    <th>{{ $subcategory->slug }}</th>
                    <th><img alt="img" style="max-width: 120px" src="{{ $subcategory->image }}" /></th>
                    <th><img alt="icon" style="max-width: 120px" src="{{ $subcategory->icon }}" /></th>
                    <th>{{ $subcategory->category_name }}</th>
                    <th class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Удалить
                        </button>


                    </th>
                    <th><a class="btn btn-primary"
                            href="{{ route('subcategories.edit', ['subcategory' => $subcategory->id]) }}">Редактировать</a>
                    </th>
                </tr>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Подтверждение удаления</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Вы уверены, что хотите удалить этот элемент?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <form action="{{ route('subcategories.destroy', ['id' => $subcategory->id]) }}"
                                    method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="btn btn-danger" type="submit">Да</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </table>
    @else
        <p>Нет подкатегорий </p>
    @endif

@endSection

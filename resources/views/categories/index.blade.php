@extends('layout.baselayot')
@section('content')
    <div class="accordion card">
        <div class="card-body">
            <h5 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">Добаволение новой категории</button>
            </h5>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label class="form-label">Название категории</label>
                        <input class="form-control" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание Категории</label>
                        <input class="form-control" type="text" name="description" placeholder="Description">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ярлычок категории (краткое описание которое отличает данную
                            категорию)</label>
                        <input class="form-control" type="text" name="slug" placeholder="Slug">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Картинка категории</label>
                        <input class="form-control" type="file" name="image" id="image" placeholder="Image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Иконка категории</label>
                        <input class="form-control" type="file" name="icon" id="icon" placeholder="Icon">
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
    @error('error')
        <div style="color: red; margin: 20px 0">{{ $message }}</div>
    @enderror
    @if ($categories->count() < 0)
        <p>Нету категорий товаров магазина, для продолжения добавитье категорий</p>
    @else
        <table class="table table-bordered border-grey mt-5">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Слауг</th>
                    <th scope="col">Картинка</th>
                    <th scope="col">Иконка</th>
                    <th scope="col">
                        удалить
                    </th>
                    <th scope="col">Редактировать</th>
                </tr>
            </thead>
            @foreach ($categories as $category)
                <tr scope="row">
                    <th>{{ $category->name }}</th>
                    <th>{{ $category->description }}</th>
                    <th>{{ $category->slug }}</th>
                    <th><img src="{{ $category->image }}" alt="asd" style="max-width: 120px"></th>
                    <th><img src="{{ $category->icon }}" alt="asd" style="max-width: 120px"></th>
                    <th class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Удалить
                        </button>
                    </th>
                    <th class=" text-center"><a href="{{ route('categories.edit', ['category' => $category->id]) }}"><button
                                class="btn btn-primary">edit</button></a>
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
                                <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST">
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
    @endif
@endSection

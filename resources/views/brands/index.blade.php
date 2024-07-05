@extends('layout.baselayot')


@section('content')
    <div class="accordion card">
        <div class="card-body">
            <h5 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Добаволение нового
                    брэнда</button></h5>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">Название брэнда</label>
                        <input class="form-control" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">Картинка брэнда</label>
                        <input class="form-control" type="file" name="image" id="image" placeholder="Image">
                    </div>
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">logo брэнда</label>
                        <input class="form-control" type="file" name="logo" id="logo" placeholder="logo">
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
    @if ($brands->count() > 0)
        <table class="table table-bordered border-grey mt-5">
            <thead>
                <tr>
                    <th>Название брэнда</th>
                    <th>Картинка</th>
                    <th>Лого</th>
                    <th>Удалить</th>
                    <th>Редактировать</th>
                </tr>
            </thead>
            @foreach ($brands as $brand)
                <tr>
                    <th>{{ $brand->name }}</th>
                    <th><img src="{{ $brand->img }}" alt="img" style="max-width: 120px" />
                    </th>
                    <th><img src="{{ $brand->logo }}" alt="img" style="max-width: 120px" /></th>
                    <th>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Удалить
                        </button>

                    </th>
                    <th class="text-center"><a class="btn btn-primary"
                            href="{{ route('brands.edit', ['brand' => $brand->id]) }}">Редактировать</a></th>
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
                                <form action="{{ route('brands.destroy', ['id' => $brand->id]) }}" method="POST">@csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Да</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @error('error')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </table>
    @else
        <p>Нет брэндов </p>
    @endif
@endSection

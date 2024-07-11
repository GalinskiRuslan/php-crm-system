@extends('layout.baselayot')

@section('content')
    <div class="accordion card">
        <div class="card-body">
            <h5 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Добаволение нового
                    товара</button></h5>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">Название товара</label>
                        <input class="form-control" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">Описание товара</label>
                        <input class="form-control" type="text" name="description" id="desc"
                            placeholder="Описание товара">
                    </div>
                    <div class="mb-3 p-3 border-bottom">
                        <label class="form-label">Цена</label>
                        <input class="form-control" type="text" name="price" id="price" placeholder="price">
                    </div>
                    <div class="mb-4 p-3 border-bottom">
                        <label class="form-label">Выберите подкатегорию</label>
                        <select class="form-select" name="subcategory_id">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 p-3 border-bottom">
                        <label class="form-label">Выберите брэнд</label>
                        <select class="form-select" name="brand_id">
                            <option value="">Без брэнда</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-4 p-3">
                        <input type="file" multiple class="form-control" name="photos[]" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div style="color: red">{{ $error }}</div>
        @endforeach
    @endif
    <h5>Товары</h5>
    @if ($items->count() > 0)
        <table class="table table-bordered border-grey mt-5">
            <tr>
                <th>Название товара</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Подкатегория</th>
                <th>Картинки</th>
                <th>Статус</th>
                <th>
                    удалить
                </th>
                <th>Редактировать</th>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <th>{{ $item->name }}</th>
                    <th>{{ $item->description }}</th>
                    <th>{{ $item->price }}</th>
                    <th>{{ $item->subcategory->name }}</th>
                    <th>
                        @foreach ($item->item_photos as $photo)
                            <div class="position-relative">
                                <img src="{{ $photo->path }}" alt="img" style="max-width: 120px" />
                                <form action="{{ route('photo.destroy', ['id' => $photo->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill border-danger bg-danger"
                                        type="submit">X</button>
                                </form>
                            </div>
                        @endforeach
                    </th>
                    <th>
                        {{ $item->status }} <form action="{{ route('item.moderate', ['id' => $item->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary" type="submit">Изменить статуc</button>

                        </form>
                    </th>
                    <th class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Удалить
                        </button>


                    </th>
                    <th><a class="btn btn-primary" href="{{ route('item.edit', ['item' => $item->id]) }}">Редактировать</a>
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
                                Вы уверены, что хотите удалить этот товар?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <form action="{{ route('item.destroy', ['id' => $item->id]) }}" method="POST">
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

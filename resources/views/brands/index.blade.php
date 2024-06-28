@extends('layout.baselayot')


@section('content')
    <h5>Брэнды</h5>
    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <div>
            <label>Картинка брэнда</label>
            <input type="file" name="image" id="image" placeholder="Image">
        </div>
        <div>
            <label>logo брэнда</label>
            <input type="file" name="logo" id="logo" placeholder="logo">
        </div>
        <button type="submit">Create</button>
    </form>
    @if ($brands->count() > 0)
        <table>
            <tr>
                <th>Название брэнда</th>
                <th>Картинка</th>
                <th>Лого</th>
                <th>Удалить</th>
                <th>Редактировать</th>
            </tr>
            @foreach ($brands as $brand)
                <tr>
                    <th>{{ $brand->name }}</th>
                    <th><img src="{{ $brand->img }}" alt="img" style="max-width: 120px" />
                    </th>
                    <th><img src="{{ $brand->logo }}" alt="img" style="max-width: 120px" /></th>
                    <th>
                        <form action="{{ route('brands.destroy', ['id' => $brand->id]) }}" method="POST">@csrf
                            @method('DELETE')
                            <button type="submit">X</button>
                        </form>
                    </th>
                    <th><a href="{{ route('brands.edit', ['brand' => $brand->id]) }}">Редактировать</a></th>
                </tr>
            @endforeach
            @error('error')
                <div style="color: red">{{ $message }}</div>
            @enderror
        </table>
    @else
        <p>Нет брэндов </p>
    @endif
@endSection

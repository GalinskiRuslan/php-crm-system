@extends('layout.baselayot')
@section('content')
    <h5>Добаволение новой категории</h5>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="slug" placeholder="Slug">
        <input type="file" name="image" id="image" placeholder="Image">
        <input type="file" name="icon" id="icon" placeholder="Icon">
        <button type="submit">Create</button>
    </form>
    @error('error')
        <div style="color: red; margin: 20px 0">{{ $message }}</div>
    @enderror
    @if ($categories->count() < 0)
        <p>Нету категорий товаров магазина, для продолжения добавитье категорий</p>
    @else
        <table>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Слауг</th>
                <th>Картинка</th>
                <th>Иконка</th>
                <th>
                    удалить
                </th>
                <th>Редактировать</th>
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <th>{{ $category->name }}</th>
                    <th>{{ $category->description }}</th>
                    <th>{{ $category->slug }}</th>
                    <th><img src="{{ $category->image }}" alt="asd" style="max-width: 120px"></th>
                    <th><img src="{{ $category->icon }}" alt="asd" style="max-width: 120px"></th>
                    <th>
                        <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit">X</button>
                        </form>
                    </th>
                    <th><a href="{{ route('categories.edit', ['category' => $category->id]) }}"><button>edit</button></a>
                    </th>
                </tr>
            @endforeach
        </table>
    @endif
@endSection

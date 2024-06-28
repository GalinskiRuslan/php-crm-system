@extends('layout.baselayot')


@section('content')

    <h1>Подкатегории</h1>


    <p>Добавление новой подкатегории</p>
    <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('POST')
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="slug" placeholder="Slug">
        <div>
            <label>Картинка подкатегории</label>
            <input type="file" name="image" id="image" placeholder="Image">
        </div>
        <div>
            <label>Иконка подкатегории</label>
            <input type="file" name="icon" id="icon" placeholder="Icon">
        </div>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit">Create</button>
        @if ($errors->all())
            @foreach ($errors->all() as $error)
                <div style="color: red">{{ $error }}</div>
            @endforeach
        @endif
    </form>
    @if ($subcategories->count() > 0)
        <table>
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
                    <th>
                        <form action="{{ route('subcategories.destroy', ['id' => $subcategory->id]) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit">X</button>
                        </form>
                    </th>
                    <th><a href="{{ route('subcategories.edit', ['subcategory' => $subcategory->id]) }}">Редактировать</a>
                    </th>
                </tr>
            @endforeach

        </table>
    @else
        <p>Нет подкатегорий </p>
    @endif

@endSection

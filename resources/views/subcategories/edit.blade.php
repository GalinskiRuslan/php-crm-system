@extends('layout.baselayot')


@section('content')
    <form action="{{ route('subcategories.update', ['id' => $subcategory->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Название подкатегории</label>
        <input type="text" name="name" value="{{ $subcategory->name }}"><br />
        <label>Описание категории</label>
        <input type="text" name="description" value="{{ $subcategory->description }}"><br />
        <label>Другое название категории</label>
        <input type="text" name="slug" value="{{ $subcategory->slug }}"><br />
        <label>Картинка категории</label>
        <img src="{{ $subcategory->image }}" alt="asd" style="max-width: 120px">
        <input type="file" name="image" id="image"><br />
        <label>Иконка категории</label>
        <img src="{{ $subcategory->icon }}" alt="asd" style="max-width: 120px"><br />
        <input type="file" name="icon" id="icon"><br />
        <button type="submit">Update</button>
    </form>
    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div style="color: red">{{ $error }}</div>
        @endforeach
    @endif
@endSection

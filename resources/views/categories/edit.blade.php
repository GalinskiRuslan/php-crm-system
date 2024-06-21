@extends('layout.baselayot')


@section('content')
    <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Название категории</label>
        <input type="text" name="name" value="{{ $category->name }}"><br />
        <label>Описание категории</label>
        <input type="text" name="description" value="{{ $category->description }}"><br />
        <label>Другое название категории</label>
        <input type="text" name="slug" value="{{ $category->slug }}"><br />
        <label>Картинка категории</label>
        <img src="{{ $category->image }}" alt="asd" style="max-width: 120px">
        <input type="file" name="image" id="image"><br />
        <label>Иконка категории</label>
        <img src="{{ $category->icon }}" alt="asd" style="max-width: 120px"><br />
        <input type="file" name="icon" id="icon"><br />
        <button type="submit">Update</button>
    </form>
    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div style="color: red">{{ $error }}</div>
        @endforeach
    @endif
@endSection

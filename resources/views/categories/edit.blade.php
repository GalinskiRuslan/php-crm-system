@extends('layout.baselayot')


@section('content')
    <form class="card" action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="mb-3 p-3 border-bottom">
                <label class="form-label">Название категории</label>
                <input class="form-control" type="text" name="name" value="{{ $category->name }}">
            </div>
            <div class="mb-3 p-3  border-bottom">
                <label class="form-label">Описание категории</label>
                <input class="form-control" type="text" name="description" value="{{ $category->description }}">
            </div>
            <div class="mb-3 p-3 border-bottom">
                <label class="form-label">Другое название категории</label>
                <input class="form-control" type="text" name="slug" value="{{ $category->slug }}">
            </div>
            <div class="mb-3 p-3 border-bottom">
                <label class="form-label">Картинка категории</label>
                <img src="{{ $category->image }}" alt="asd" style="max-width: 120px">
                <input class="form-control" type="file" name="image" id="image">
            </div>
            <div class="mb-3 p-3 border-bottom">
                <label class="form-label">Иконка категории</label>
                <img src="{{ $category->icon }}" alt="asd" style="max-width: 120px">
                <input class="form-control" type="file" name="icon" id="icon">
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div style="color: red">{{ $error }}</div>
        @endforeach
    @endif
@endSection

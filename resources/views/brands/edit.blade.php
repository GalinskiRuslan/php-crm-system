@extends('layout.baselayot')


@section('content')
    <form class="card" action="{{ route('brands.update', ['id' => $brand->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="p-3 mb-3 border-bottom">
                <label class="form-label">Название брэнда</label>
                <input class="form-control" type="text" name="name" value="{{ $brand->name }}">
            </div>
            <div class="p-3 mb-3 border-bottom">
                <label class="form-label">Картинка брэнда</label>
                <img src="{{ $brand->img }}" alt="asd" style="max-width: 120px">
                <input class="form-control" type="file" name="image" id="image">
            </div>
            <div class="p-3 mb-3 border-bottom">
                <label class="form-label">Иконка брэнда</label>
                <img src="{{ $brand->logo }}" alt="asd" style="max-width: 120px">
                <input class="form-control" type="file" name="logo" id="logo">
            </div>
            <button class="btn btn-primary mt-3" type="submit">Update</button>
        </div>
    </form>
    @error('error')
        <div style="color: red">{{ $message }}</div>
    @enderror
@endSection

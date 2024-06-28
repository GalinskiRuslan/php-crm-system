@extends('layout.baselayot')


@section('content')
    <form action="{{ route('brands.update', ['id' => $brand->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Название брэнда</label>
        <input type="text" name="name" value="{{ $brand->name }}"><br />
        <label>Картинка брэнда</label>
        <img src="{{ $brand->img }}" alt="asd" style="max-width: 120px">
        <input type="file" name="image" id="image"><br />
        <label>Иконка брэнда</label>
        <img src="{{ $brand->logo }}" alt="asd" style="max-width: 120px"><br />
        <input type="file" name="logo" id="logo"><br />
        <button type="submit">Update</button>
    </form>
    @error('error')
        <div style="color: red">{{ $message }}</div>
    @enderror
@endSection

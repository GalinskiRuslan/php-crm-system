@extends('layout.baselayot')


@section('content')
    <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $category->name }}">
        <input type="text" name="description" value="{{ $category->description }}">
        <input type="text" name="slug" value="{{ $category->slug }}">
        <img src="{{ $category->image }}" alt="asd" style="max-width: 120px">
        <input type="file" name="image" id="image">
        <button type="submit">Update</button>
    </form>
@endSection

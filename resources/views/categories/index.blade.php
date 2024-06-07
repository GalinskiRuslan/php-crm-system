@extends('layout.baselayot')





@section('content')
    @foreach ($categories as $category)
        <div>{{ $category->name }}
            {{ $category->description }}
            {{ $category->slug }}
            <img src="{{ $category->image }}" alt="asd" style="max-width: 120px">

            <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST"><input type="hidden"
                    name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button
                    type="submit">X</button></form>

        </div>
    @endforeach
    <h5>Добаволение новой категории</h5>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="slug" placeholder="Slug">
        <input type="file" name="image" id="image" placeholder="Image">
        <button type="submit">Create</button>
    </form>
@endSection

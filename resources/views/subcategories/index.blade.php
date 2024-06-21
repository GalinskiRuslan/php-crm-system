@extends('layout.baselayot')


@section('content')
    @if ($subcategories->count() > 1)
        @foreach ($subcategories as $subcategory)
            <p>{{ $subcategory->name }}</p>
        @endforeach
    @else
        <p>Нету подкатегорий </p>
    @endif
    <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">

    </form>
@endSection

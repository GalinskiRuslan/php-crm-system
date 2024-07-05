@extends('layout.baselayot')

@section('content')
    <div class="d-flex vh-100 flex-row justify-content-center align-items-center">
        @foreach ($item as $items)
            <p class="text-center">{{ $items->name }}</p>
        @endforeach
    </div>
@endSection

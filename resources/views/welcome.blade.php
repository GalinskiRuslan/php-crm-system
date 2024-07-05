@extends('layout.baselayot')


@section('content')
    <div class="d-flex vh-100 flex-row justify-content-center align-items-center">
        @auth
            <p class="text-center">Это панель управления интернет-магазином</p>
        @endauth
        @guest
            <form action="{{ route('login') }}" method="POST" class="d-flex flex-column">
                @csrf
                <input class="form-control mt-3" type="text" name="phone" placeholder="Phone" id="phone"
                    value="{{ old('phone') }}">
                <input class="form-control mt-3" type="text" name="password" placeholder="Password" type="password">
                <button class="btn btn-primary mt-3" type="submit">Login</button>
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </form>
        @endguest
        @error('accessError')
            <div class="error-message" style="color: red">{{ $message }}</div>
        @enderror
    </div>
@endSection

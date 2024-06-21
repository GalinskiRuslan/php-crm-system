@extends('layout.baselayot')


@section('content')
    @auth
        <p>Это панель управления интернет-магазином</p>
    @endauth
    @guest
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <input type="text" name="phone" placeholder="Phone" id="phone" value="{{ old('phone') }}">
            <input type="text" name="password" placeholder="Password" type="password">
            <button type="submit">Login</button>
            @error('phone')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </form>
    @endguest

    @error('accessError')
        <div class="error-message" style="color: red">{{ $message }}</div>
    @enderror
@endSection

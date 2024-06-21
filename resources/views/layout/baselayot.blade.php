<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title', 'SHOP CRM')</title>
</head>

<body class="container">
    @auth
        <header>
            <a href="{{ route('home') }}">
                <p>Shop CMS</p>
            </a>
            <div>
                <a href="{{ route('categories') }}">Категории</a>
                <a href="{{ route('subcategories') }}">Подкатегории</a>
            </div>
            <div style="display: flex; align-items: center; gap: 10px">
                <p>Вы вошли как {{ Auth::user()->name }}</p>
                <a href="{{ route('logout') }}">Выйти</a>
            </div>
        </header>
    @endauth
    <main>@yield('content')</main>
    <footer></footer>
</body>
@stack('js')
@stack('css')

</html>

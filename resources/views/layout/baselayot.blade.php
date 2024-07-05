<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('title', 'SHOP CRM')</title>
</head>

<body class="container">
    @auth
        <header>
            <nav class="navbar navbar-expand-lg d-flex justify-content-between w-100">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between w-100" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <a class="navbar-brand" href="{{ route('home') }}">Shop CMS</a>
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Контент магазина
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="{{ route('categories') }}">Категории</a></li>
                                    <li><a class="dropdown-item" href="{{ route('subcategories') }}">Подкатегории</a></li>
                                    <li><a class="dropdown-item" href="{{ route('brands') }}">Брeнды</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center gap-3">
                            <div>{{ Auth::user()->name }}</div>
                            <a class="btn btn-danger" href="{{ route('logout') }}">Выйти</a>
                        </div>
                    </div>
                </div>

            </nav>

        </header>
    @endauth
    <main>@yield('content')</main>
    <footer></footer>
</body>
@stack('js')
@stack('css')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


</html>

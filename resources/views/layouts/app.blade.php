<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Online Tests')</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__logo">
            <a href="{{ route('home') }}">Online Tests</a>
        </div>
        <button class="mobile-menu-button">
            <i class="fas fa-bars"></i>
        </button>
        <div class="header__auth" id="mobileMenu">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="btn btn-admin">Админ панель</a>
                @endif
                <a href="{{ route('tests.my') }}" class="btn btn-my-tests">Мои тесты</a>
                <a href="{{ route('tests.create') }}" class="btn btn-add-test">Добавить тест</a>
                <a href="{{ route('profile') }}" class="btn btn-profile">Профиль</a>
                <span class="user-name">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-logout">Выйти</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn btn-register">Регистрация</a>
                <a href="{{ route('login') }}" class="btn btn-login">Войти</a>
            @endauth
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2025 Online Tests</p>
    </footer>
    <script>
        const menuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.header__auth');

        if (menuButton && mobileMenu) {
            menuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('show');
            });
        }
    </script>
    <script src="{{ asset('javascript/alert.js') }}"></script>
</body>
</html>

@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <section>
        <div class="profile-container">
            @if (session('success'))
            <div class="alert alert-success" id="alert">
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="closeAlert()">×</button>
            </div>
            @endif
            <div class="profile-info-container">
                <div class="account-data">
                    <div class="current-accaunt-data">
                        <h2>Данные аккаунта</h2>
                        <div class="account-data__item">
                            <span>Имя:</span>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <div class="account-data__item">
                            <span>E-mail:</span>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="change-accaunt-data">
                        <h2>Изменить данные</h2>

                        <form method="POST" action="{{ route('profile.change-name') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Новое имя</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value=""
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-change-name">Изменить имя</button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('profile.change-password') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">Текущий пароль</label>
                                <input type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                    <div class="error">{{ $message }}</div>
                                @enderror

                                <label for="password">Новый пароль</label>
                                <input type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="error">{{ $message }}</div>
                                @enderror

                                <label for="password_confirmation">Подтверждение нового пароля</label>
                                <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                                @error('password_confirmation')
                                    <div class="error">{{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn btn-change-password">Изменить пароль</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

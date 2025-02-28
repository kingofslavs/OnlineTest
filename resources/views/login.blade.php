@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
<div class="login-container">
    <h1>Авторизация</h1>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="h-captcha" data-sitekey="{{ config('services.hcaptcha.sitekey') }}"></div>

                @error('h-captcha-response')
                    <div class="error">Капча должна быть пройдена</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-login">Войти</button>
    </form>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</div>
@endsection

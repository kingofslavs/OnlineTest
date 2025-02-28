@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="container">
    <!-- Панель поиска -->
    <div class="card mb-5">
        <div class="card-body-search">
            <h3 class="card-title">Поиск тестов</h3>
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           placeholder="Поиск по названию..."
                           value="{{ request('search') }}"
                           class="form-control">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <h2>Доступные тесты</h2>

    @if($tests->isEmpty())
        <p class="no-tests">Пока нет доступных тестов</p>
    @else
        <div class="tests-grid">
            @foreach($tests as $test)
                <div class="test-card">
                    <h3 class="test-title">{{ $test->title }}</h3>
                    <p class="test-description">{{ $test->description ?? 'Без описания' }}</p>
                    <div class="test-footer">
                        <div class="test-info">
                            <span class="test-date">Создан: {{ $test->created_at->format('d.m.Y') }}</span>
                            <span class="test-author">Автор: {{ $test->author->name }}</span>
                        </div>
                        <a href="{{ route('tests.show', $test->id) }}" class="btn btn-start">Начать тест</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
    <div class="container">
        <h2>Доступные тесты</h2>
        @foreach($tests as $test)
            <div class="test-card-admin">
                <h3>{{ $test->title }}</h3>
                <p>{{ $test->description }}</p>
                <p class="test-date">Создан: {{ $test->created_at->format('d.m.Y') }}</p>
                <p class="test-author">Автор: {{ $test->author->name }}</p>
                <div class="admin-action-buttons">
                    <a href="{{ route('tests.show', $test->id) }}" class="btn btn-primary">Просмотр</a>
                    <a href="{{ route('admin.tests.edit', $test->id) }}" class="btn btn-primary">Редактировать тест</a>
                    <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот тест?')">Удалить тест</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

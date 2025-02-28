@extends('layouts.app')

@section('title', 'Редактирование моего теста')

@section('content')
    <div class="container">
        <h1>Редактировать тест</h1>

        @if (session('success'))
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
            <button type="button" class="alert-close" onclick="closeAlert()">×</button>
        </div>
        @endif

        <form action="{{ route('tests.update', $test->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Название:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $test->title }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" class="form-control">{{ $test->description }}</textarea>
            </div>

            <div class="edit-actions">
                <button type="submit" class="btn btn-primary">Обновить тест</button>
                <a href="{{ route('tests.questions', $test->id) }}" class="btn btn-primary">Управление вопросами</a>
                <a href="{{ route('tests.my') }}" class="btn btn-primary">Назад</a>
            </div>
        </form>
    </div>
@endsection

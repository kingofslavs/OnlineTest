@extends('layouts.app')

@section('title', 'Мои тесты')

@section('content')
<div class="container">
    <h2>Мои тесты</h2>

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="closeAlert()">×</button>
    </div>
    @endif

    @if($tests->isEmpty())
        <p class="no-tests">У вас пока нет созданных тестов</p>
    @else
        <div class="tests-grid-my-test">
            @foreach($tests as $test)
                <div class="test-card my-test">
                    <h3 class="test-title">{{ $test->title }}</h3>
                    <p class="test-description">{{ $test->description ?? 'Без описания' }}</p>
                    <div class="test-footer">
                        <div class="test-info">
                            <span class="test-date">Создан: {{ $test->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="test-edit-user">
                            <a href="{{ route('tests.show', $test->id) }}" class="btn btn-primary">Просмотр</a>
                            <a href="{{ route('tests.editMyTest', $test->id) }}" class="btn btn-success">Редактировать тест</a>
                            <form action="{{ route('tests.destroy', $test->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот тест?')">Удалить тест</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

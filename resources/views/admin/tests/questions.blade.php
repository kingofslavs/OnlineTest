@extends('layouts.app')

@section('title', 'Управление вопросами теста')

@section('content')
<div class="container">
    <h1>Вопросы теста "{{ $test->title }}"</h1>

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="closeAlert()">×</button>
    </div>
    @endif

    <div class="questions-list">
        @foreach($test->questions as $question)
            <div class="question-card">
                <div class="question-content">
                    <h3>{{ $question->question_text }}</h3>
                    <div class="options-list">
                        <strong>Варианты ответов:</strong>
                        <ul>
                            @foreach($question->options as $option)
                                <li class="{{ $option === $question->correct_answer ? 'correct-answer' : '' }}">
                                    {{ $option }}
                                    @if($option === $question->correct_answer)
                                        (Правильный ответ)
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="question-actions">
                    <a href="{{ route('admin.questions.edit', $question->id) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот вопрос?')">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="actions mt-4">
        <a href="{{ route('admin.questions.add', $test->id) }}" class="btn btn-success">Добавить вопрос</a>
        <a href="{{ route('admin.tests.edit', $test->id) }}" class="btn btn-primary">Назад к тесту</a>
    </div>
</div>
@endsection

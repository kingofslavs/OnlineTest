@extends('layouts.app')

@section('title', 'Вопросы теста')

@section('content')
<div class="container">
    <div class="test-header">
        <h1>{{ $test->title }}</h1>
        @if($test->description)
            <p class="test-description">{{ $test->description }}</p>
        @endif
    </div>

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="closeAlert()">×</button>
    </div>
    @endif

    <div class="questions-list">
        @forelse($test->questions as $index => $question)
            <div class="question-card">
                <h3 class="question-number">Вопрос {{ $index + 1 }}</h3>
                <div class="question-content">
                    <p class="question-text">{{ $question->question_text }}</p>

                    <div class="options-list-userEdit">
                        <h4>Варианты ответов:</h4>
                        <ul>
                            @foreach($question->options as $option)
                                <li class="{{ $option === $question->correct_answer ? 'correct-answer' : '' }}">
                                    {{ $option }}
                                    @if($option === $question->correct_answer)
                                        <span class="badge bg-success">Правильный ответ</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="question-actions mt-3">
                        <a href="{{ route('tests.edit_question', ['test' => $test->id, 'question' => $question->id]) }}"
                            class="btn btn-primary">Редактировать вопрос</a>

                        <form action="{{ route('tests.questions.destroy', ['test' => $test->id, 'question' => $question->id]) }}"
                              method="POST"
                              style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Вы уверены, что хотите удалить этот вопрос?')">
                                Удалить вопрос
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="no-questions">В этом тесте пока нет вопросов</p>
        @endforelse
    </div>

    <div class="actions mt-4">
        <a href="{{ route('tests.questions.add', $test->id) }}" class="btn btn-success">
            Добавить вопрос
        </a>
        <a href="{{ route('tests.my') }}" class="btn btn-primary">Назад к моим тестам</a>
    </div>
</div>
@endsection

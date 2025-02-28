@extends('layouts.app')

@section('title', $test->title)

@section('content')
<div class="container test-view">
    <div class="test-header">
        <h1>{{ $test->title }}</h1>
        @if($test->description)
            <p class="test-description">{{ $test->description }}</p>
        @endif
    </div>

    <form action="{{ route('tests.check', $test->id) }}" method="POST">
        @csrf
        <div class="questions-list">
            @forelse($test->questions as $index => $question)
                <div class="question-card">
                    <h3 class="question-number">Вопрос {{ $index + 1 }}</h3>
                    <p class="question-text">{{ $question->question_text }}</p>
                    
                    <div class="options-list">
                        @foreach($question->options as $option)
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required>
                                <span class="option-text">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="no-questions">В этом тесте пока нет вопросов</p>
            @endforelse
        </div>

        @if(count($test->questions) > 0)
            <div class="test-actions">
                <button type="submit" class="btn btn-check-answers">Проверить ответы</button>
            </div>
        @endif
    </form>
</div>
@endsection

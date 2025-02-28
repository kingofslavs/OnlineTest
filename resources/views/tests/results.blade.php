@extends('layouts.app')

@section('title', 'Результаты теста - ' . $test->title)

@section('content')
<div class="container test-view">
    <div class="results-header">
        <h1>Результаты теста</h1>
        <div class="score-card">
            <div class="score-value">{{ number_format($score, 1) }}%</div>
            <div class="score-label">Правильных ответов</div>
            <div class="score-details">{{ array_sum(array_column($results, 'is_correct')) }} из {{ count($results) }}</div>
        </div>
    </div>

    <div class="results-list">
        @foreach($results as $result)
            <div class="result-card {{ $result['is_correct'] ? 'correct' : 'incorrect' }}">
                <div class="result-status">
                    @if($result['is_correct'])
                        <span class="status-icon">✓</span>
                    @else
                        <span class="status-icon">✗</span>
                    @endif
                </div>
                <div class="result-content">
                    <h3>{{ $result['question'] }}</h3>
                    <div class="answer-info">
                        <div class="user-answer">
                            <span class="answer-label">Ваш ответ:</span>
                            <span>{{ $result['user_answer'] }}</span>
                        </div>
                        @if(!$result['is_correct'])
                            <div class="correct-answer">
                                <span class="answer-label">Правильный ответ:</span>
                                <span>{{ $result['correct_answer'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="results-actions">
        <a href="{{ route('home') }}" class="btn btn-primary">К списку тестов</a>
    </div>
</div>
@endsection

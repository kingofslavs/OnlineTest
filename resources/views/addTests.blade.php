@extends('layouts.app')

@section('title', 'Создание теста')

@section('content')
<div class="container">
    <h2>Создать новый тест</h2>

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="closeAlert()">×</button>
    </div>
    @endif

    <form action="{{ route('tests.store') }}" method="POST" id="testForm">
        @csrf
        <div class="test-creation-layout">
            <div class="test-info-column">
                <div class="mb-3">
                    <label for="title" class="form-label">Название теста</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control description-area" id="description" name="description"></textarea>
                </div>
            </div>

            <div class="questions-column">
                <div class="questions-header">
                    <h3>Вопросы теста</h3>
                    <button type="button" class="btn btn-add-new-question" id="add-question">
                        <span class="btn-icon">+</span> Добавить вопрос
                    </button>
                </div>

                <div id="questions-container">
                    <div class="question-section mb-4">
                        <h3>Вопрос 1</h3>
                        <div class="mb-3">
                            <label class="form-label">Текст вопроса</label>
                            <textarea class="form-control" name="questions[0][text]" required></textarea>
                        </div>
                        <div class="options-container">
                            <div class="mb-3">
                                <label class="form-label">Вариант ответа 1</label>
                                <input type="text" class="form-control" name="questions[0][options][]" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Вариант ответа 2</label>
                                <input type="text" class="form-control" name="questions[0][options][]" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-option">
                            <span class="btn-icon">+</span> Добавить вариант
                        </button>
                        <div class="mb-3">
                            <label class="form-label">Правильный ответ</label>
                            <input type="text" class="form-control" name="questions[0][correct_answer]" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Создать тест</button>
        </div>
    </form>
</div>

<script>
let questionCount = 1;

document.getElementById('add-question').addEventListener('click', function() {
    const container = document.getElementById('questions-container');
    const questionHTML = `
        <div class="question-section mb-4">
            <h3>Вопрос ${questionCount + 1}</h3>
            <div class="mb-3">
                <label class="form-label">Текст вопроса</label>
                <textarea class="form-control" name="questions[${questionCount}][text]" required></textarea>
            </div>
            <div class="options-container">
                <div class="mb-3">
                    <label class="form-label">Вариант ответа 1</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Вариант ответа 2</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                </div>
            </div>
            <button type="button" class="btn btn-add-option">
                <span class="btn-icon">+</span> Добавить вариант
            </button>
            <div class="mb-3">
                <label class="form-label">Правильный ответ</label>
                <input type="text" class="form-control" name="questions[${questionCount}][correct_answer]" required>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', questionHTML);
    questionCount++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-add-option')) {
        const questionSection = e.target.closest('.question-section');
        const questionIndex = Array.from(questionSection.parentNode.children).indexOf(questionSection);
        const optionsContainer = questionSection.querySelector('.options-container');
        const optionCount = optionsContainer.children.length + 1;

        const optionHTML = `
            <div class="mb-3">
                <label class="form-label">Вариант ответа ${optionCount}</label>
                <input type="text" class="form-control" name="questions[${questionIndex}][options][]" required>
            </div>
        `;
        optionsContainer.insertAdjacentHTML('beforeend', optionHTML);
    }
});
</script>
@endsection

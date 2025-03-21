@extends('layouts.app')

@section('title', 'Добавление вопроса')

@section('content')
<div class="container">
    <h2>Добавить вопрос к тесту "{{ $test->title }}"</h2>

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
        <button type="button" class="alert-close" onclick="closeAlert()">×</button>
    </div>
    @endif

    <form action="{{ route('tests.questions.store', $test->id) }}" method="POST" class="question-form">
        @csrf
        <div class="mb-3">
            <label for="question_text" class="form-label">Вопрос</label>
            <textarea class="form-control" id="question_text" name="question_text" required></textarea>
        </div>

        <div id="options-container">
            <div class="mb-3">
                <div class="option-row">
                    <label class="form-label">Вариант ответа 1</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="options[]" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="option-row">
                    <label class="form-label">Вариант ответа 2</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="options[]" required>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-add-option mb-3" onclick="addOption()">
            + Добавить вариант ответа
        </button>

        <div class="mb-3">
            <label for="correct_answer" class="form-label">Правильный ответ</label>
            <input type="text" class="form-control" id="correct_answer" name="correct_answer" required>
        </div>
        <div class="actions">
            <button type="submit" class="btn btn-primary">Добавить вопрос</button>
            <a href="{{ route('tests.questions', $test->id) }}" class="btn btn-primary">Назад</a>
        </div>
    </form>
</div>

<script>
function addOption() {
    const container = document.getElementById('options-container');
    const optionCount = container.children.length + 1;

    const newOption = document.createElement('div');
    newOption.className = 'mb-3';
    newOption.innerHTML = `
        <div class="option-row">
            <label class="form-label">Вариант ответа ${optionCount}</label>
            <div class="d-flex">
                <input type="text" class="form-control" name="options[]" required>
                <button type="button" class="btn btn-danger ms-2" onclick="deleteOption(this)">✖</button>
            </div>
        </div>
    `;
    container.appendChild(newOption);
}

function deleteOption(button) {
    const container = document.getElementById('options-container');
    if (container.children.length > 2) {
        button.closest('.mb-3').remove();
        const labels = container.querySelectorAll('.form-label');
        labels.forEach((label, index) => {
            label.textContent = `Вариант ответа ${index + 1}`;
        });
    }
}
</script>

<style>
.option-row {
    position: relative;
}
.btn-add-option {
    background-color: #28a745;
    color: white;
}
.btn-add-option:hover {
    background-color: #218838;
    color: white;
}
.btn-danger {
    padding: 0.375rem 0.75rem;
}
.d-flex {
    display: flex;
    gap: 10px;
}
</style>
@endsection

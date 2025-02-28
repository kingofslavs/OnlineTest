@extends('layouts.app')

@section('title', 'Редактирование вопроса')

@section('content')
<div class="container">
    <h1>Редактирование вопроса</h1>

    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="question_text">Текст вопроса:</label>
            <textarea name="question_text" id="question_text" class="form-control" required>{{ $question->question_text }}</textarea>
        </div>

        <div class="form-group">
            <label>Варианты ответов:</label>
            <div id="options-container">
                @foreach($question->options as $index => $option)
                    <div class="option-input mb-2">
                        <div class="option-row">
                            <input type="text" name="options[]" class="form-control" value="{{ $option }}" required>
                            <button type="button" class="btn btn-delete-option" onclick="deleteOption(this)" {{ count($question->options) <= 2 ? 'disabled' : '' }}>
                                <i>✖</i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary mt-2" onclick="addOption()">Добавить вариант</button>
        </div>

        <div class="form-group">
            <label for="correct_answer">Правильный ответ:</label>
            <input type="text" name="correct_answer" id="correct_answer" class="form-control" value="{{ $question->correct_answer }}" required>
        </div>

        <div class="edit-actions">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('admin.tests.questions', $question->test_id) }}" class="btn btn-primary">Назад</a>
        </div>
    </form>
</div>

<script>
function addOption() {
    const container = document.getElementById('options-container');
    const newOption = document.createElement('div');
    newOption.className = 'option-input mb-2';
    newOption.innerHTML = `
        <div class="option-row">
            <input type="text" name="options[]" class="form-control" required>
            <button type="button" class="btn btn-delete-option" onclick="deleteOption(this)">
                <i>✖</i>
            </button>
        </div>
    `;
    container.appendChild(newOption);
    updateDeleteButtons();
}

function deleteOption(button) {
    const container = document.getElementById('options-container');
    const optionInput = button.closest('.option-input');
    if (container.children.length > 2) {
        optionInput.remove();
        updateDeleteButtons();
    }
}

function updateDeleteButtons() {
    const container = document.getElementById('options-container');
    const deleteButtons = container.querySelectorAll('.btn-delete-option');
    const isDisabled = container.children.length <= 2;
    
    deleteButtons.forEach(btn => {
        btn.disabled = isDisabled;
        btn.style.opacity = isDisabled ? '0.5' : '1';
        btn.style.cursor = isDisabled ? 'not-allowed' : 'pointer';
    });
}

document.addEventListener('DOMContentLoaded', updateDeleteButtons);
</script>
@endsection

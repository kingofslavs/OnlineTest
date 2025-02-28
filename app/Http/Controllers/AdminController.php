<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return view('admin.index', compact('tests'));
    }

    public function editTest($id)
    {
        $test = Test::findOrFail($id);
        return view('admin.tests.edit', compact('test'));
    }

    public function updateTest(Request $request, $id){
        $test = Test::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.index')->with('success', 'Тест успешно обновлен!');
    }

    public function destroyTest($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return redirect()->route('admin.index')->with('success', 'Тест успешно удален!');
    }

    public function editQuestions($testId)
    {
        $test = Test::with('questions')->findOrFail($testId);
        return view('admin.tests.questions', compact('test'));
    }

    public function editQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        return view('admin.questions.edit', compact('question'));
    }

    public function updateQuestion(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string'
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer
        ]);

        return redirect()->route('admin.tests.questions', $question->test_id)
            ->with('success', 'Вопрос успешно обновлен!');
    }

    public function destroyQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        $testId = $question->test_id;
        $question->delete();

        return redirect()->route('admin.tests.questions', $testId)
            ->with('success', 'Вопрос успешно удален!');
    }

    public function addQuestion($id)
    {
        $test = Test::findOrFail($id);
        return view('admin.questions.addQuestion', compact('test'));
    }

    public function storeQuestion(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string'
        ]);
    
        if (!in_array($validated['correct_answer'], $validated['options'])) {
            $validated['options'][] = $validated['correct_answer'];
        }
    
        $test->questions()->create([
            'question_text' => $validated['question_text'],
            'correct_answer' => $validated['correct_answer'],
            'options' => array_values(array_unique($validated['options']))
        ]);
    
        return redirect()->back()->with('success', 'Вопрос успешно добавлен!');
    }
}

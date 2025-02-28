<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;

use function Ramsey\Uuid\v1;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Test::with('author')->latest();
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $tests = $query->get();
        return view('home', compact('tests'));
    }

    public function create()
    {
        return view('addTests');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|string'
        ]);

        $test = Test::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        foreach ($request->questions as $questionData) {
            $test->questions()->create([
                'question_text' => $questionData['text'],
                'correct_answer' => $questionData['correct_answer'],
                'options' => $questionData['options']
            ]);
        }

        return redirect()->route('home')->with('success', 'Тест успешно создан!');
    }

    public function show($id)
    {
        $test = Test::with(['questions', 'author'])->findOrFail($id);
        return view('tests.show', compact('test'));
    }

    public function addQuestion($id)
    {
        $test = Test::findOrFail($id);
        return view('tests.add_question', compact('test'));
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

    public function myTests()
    {
        $tests = Test::where('user_id', auth()->id())
                    ->with('author')
                    ->latest()
                    ->get();
        return view('tests.my', compact('tests'));
    }

    public function checkAnswers(Request $request, $id)
    {
        $test = Test::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $results = [];
        $correctCount = 0;

        foreach ($test->questions as $question) {
            $isCorrect = isset($answers[$question->id]) && 
                        $answers[$question->id] === $question->correct_answer;
            
            $results[$question->id] = [
                'question' => $question->question_text,
                'user_answer' => $answers[$question->id] ?? 'Не отвечено',
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];

            if ($isCorrect) {
                $correctCount++;
            }
        }

        $totalQuestions = count($test->questions);
        $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        return view('tests.results', compact('test', 'results', 'score'));
    }

    public function edit($id)
    {
        $test = Test::findOrFail($id);
        return view('tests.editMyTest', compact('test'));
    }

    public function update(Request $request, $id){
        $test = Test::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('tests.my')->with('success', 'Тест успешно обновлен!');
    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return redirect()->route('tests.my')->with('success', 'Тест успешно удален!');
    }

    public function destroyQuestion($testId, $questionId)
    {
        $test = Test::findOrFail($testId);
        $question = Question::findOrFail($questionId);
        
        if ($question->test_id !== $test->id) {
            abort(403, 'Вопрос не принадлежит этому тесту');
        }
    
        $question->delete();
        
        return redirect()->route('tests.questions', $testId)
            ->with('success', 'Вопрос успешно удален!');
    }

    public function showQuestions($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        return view('tests.questions', compact('test'));
    }

    public function editQuestion($testId, $questionId)
    {
        $test = Test::findOrFail($testId);
        $question = Question::findOrFail($questionId);
        
        if ($question->test_id !== $test->id) {
            abort(403, 'Вопрос не принадлежит этому тесту');
        }
        
        return view('tests.edit_question', compact('test', 'question'));
    }

    public function updateQuestion(Request $request, $testId, $questionId)
    {
        $test = Test::findOrFail($testId);
        $question = Question::findOrFail($questionId);
        
        if ($question->test_id !== $test->id) {
            abort(403, 'Вопрос не принадлежит этому тесту');
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string'
        ]);

        if (!in_array($validated['correct_answer'], $validated['options'])) {
            $validated['options'][] = $validated['correct_answer'];
        }

        $question->update([
            'question_text' => $validated['question_text'],
            'options' => array_values(array_unique($validated['options'])),
            'correct_answer' => $validated['correct_answer']
        ]);

        return redirect()->route('tests.questions', $testId)
            ->with('success', 'Вопрос успешно обновлен!');
    }
}

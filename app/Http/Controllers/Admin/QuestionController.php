<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Experiment;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index(Request $request, Experiment $experiment): View
    {
        $this->ensureAdmin($request);

        $questions = $experiment->questions()->with('answers')->get();

        return view('admin.questions.index', compact('experiment', 'questions'));
    }

    public function create(Request $request, Experiment $experiment): View
    {
        $this->ensureAdmin($request);

        return view('admin.questions.create', compact('experiment'));
    }

    public function store(QuestionRequest $request, Experiment $experiment): RedirectResponse
    {
        $this->ensureAdmin($request);

        $question = $experiment->questions()->create([
            'question_text' => $request->validated()['question_text'],
        ]);

        $answerTexts = $request->input('answer_texts', []);
        $correctIndex = (int) $request->input('correct_answer_index');

        foreach ($answerTexts as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $index === $correctIndex,
            ]);
        }

        return redirect()->route('admin.experiments.questions.index', $experiment)
            ->with('success', 'Pertanyaan kuis berhasil dibuat.');
    }

    public function edit(Request $request, Experiment $experiment, Question $question): View
    {
        $this->ensureAdmin($request);

        if ($question->experiment_id !== $experiment->id) {
            abort(404);
        }

        $question->load('answers');

        return view('admin.questions.edit', compact('experiment', 'question'));
    }

    public function update(QuestionRequest $request, Experiment $experiment, Question $question): RedirectResponse
    {
        $this->ensureAdmin($request);

        if ($question->experiment_id !== $experiment->id) {
            abort(404);
        }

        $question->update(['question_text' => $request->validated()['question_text']]);

        $question->answers()->delete();

        $answerTexts = $request->input('answer_texts', []);
        $correctIndex = (int) $request->input('correct_answer_index');

        foreach ($answerTexts as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $index === $correctIndex,
            ]);
        }

        return redirect()->route('admin.experiments.questions.index', $experiment)
            ->with('success', 'Pertanyaan kuis berhasil diperbarui.');
    }

    public function destroy(Request $request, Experiment $experiment, Question $question): RedirectResponse
    {
        $this->ensureAdmin($request);

        if ($question->experiment_id !== $experiment->id) {
            abort(404);
        }

        $question->delete();

        return redirect()->route('admin.experiments.questions.index', $experiment)
            ->with('success', 'Pertanyaan kuis berhasil dihapus.');
    }
}

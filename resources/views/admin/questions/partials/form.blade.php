<div class="space-y-6">
    <div>
        <label class="font-semibold text-sm text-gray-700">Pertanyaan</label>
        <textarea name="question_text" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">{{ old('question_text', $question->question_text ?? '') }}</textarea>
        @error('question_text')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    @php
        $existingAnswers = old('answer_texts', isset($question) ? $question->answers->pluck('answer_text')->toArray() : []);
        $correctIndex = old('correct_answer_index', isset($question) ? $question->answers->search(fn($answer) => $answer->is_correct) : 0);
        $answers = array_pad($existingAnswers, 4, '');
    @endphp

    <div class="grid gap-6">
        @foreach($answers as $index => $answerText)
            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <label class="font-semibold text-sm text-gray-700">Jawaban {{ $index + 1 }}</label>
                        <input type="text" name="answer_texts[]" value="{{ $answerText }}" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
                        @error('answer_texts.' . $index)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="correct_{{ $index }}" type="radio" name="correct_answer_index" value="{{ $index }}" {{ (int)$correctIndex === $index ? 'checked' : '' }} class="h-4 w-4 text-brand focus:ring-brand" />
                        <label for="correct_{{ $index }}" class="text-sm text-gray-700">Jawaban benar</label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @error('correct_answer_index')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

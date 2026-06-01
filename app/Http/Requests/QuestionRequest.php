<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_text' => ['required', 'string'],
            'answer_texts' => ['required', 'array', 'min:2'],
            'answer_texts.*' => ['required', 'string'],
            'correct_answer_index' => ['required', 'integer', 'between:0,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'answer_texts.required' => 'Harap tambahkan minimal dua jawaban.',
            'answer_texts.*.required' => 'Setiap jawaban harus diisi.',
            'correct_answer_index.required' => 'Pilih jawaban yang benar.',
        ];
    }
}

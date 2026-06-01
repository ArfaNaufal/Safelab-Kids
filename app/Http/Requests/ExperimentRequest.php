<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperimentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'difficulty' => ['required', 'in:Mudah,Sedang,Sulit'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'points_reward' => ['required', 'integer', 'min:0'],
            'simulation_data' => ['required', 'string'],
        ];
    }
}

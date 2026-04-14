<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $table = 'quiz_results';
    protected $fillable = ['user_id', 'experiment_id', 'score', 'correct_answers', 'total_questions'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }
}

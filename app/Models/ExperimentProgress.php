<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperimentProgress extends Model
{
    protected $table = 'experiment_progress';
    protected $fillable = ['user_id', 'experiment_id', 'status', 'current_step', 'score', 'completed_at'];
    protected $casts = [
        'completed_at' => 'datetime',
        'current_step' => 'integer',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function experiment() { return $this->belongsTo(Experiment::class); }
}

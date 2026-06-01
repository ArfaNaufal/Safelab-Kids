<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'category', 'difficulty', 'duration_minutes', 'points_reward', 'simulation_data'];
    
    // Cast JSON to array automatically
    protected $casts = [
        'simulation_data' => 'array',
    ];

    public function materials() {
        return $this->hasMany(Material::class);
    }

    public function progress() {
        return $this->hasMany(ExperimentProgress::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/experiments', [PageController::class, 'catalog'])->name('catalog');
Route::get('/simulation/{id}', [PageController::class, 'simulation'])->name('simulation');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::post('/simulation/{id}/progress', [PageController::class, 'progress'])->name('simulation.progress');
    Route::get('/simulation/{id}/quiz', [PageController::class, 'quiz'])->name('quiz');
    Route::post('/simulation/{id}/quiz/submit', [PageController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz-results/{id}', [PageController::class, 'quizResults'])->name('quiz.results');
});

require __DIR__.'/auth.php';

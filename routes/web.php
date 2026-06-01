<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExperimentController;
use App\Http\Controllers\Admin\QuestionController;
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

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/experiments', [ExperimentController::class, 'index'])->name('experiments.index');
        Route::get('/experiments/create', [ExperimentController::class, 'create'])->name('experiments.create');
        Route::post('/experiments', [ExperimentController::class, 'store'])->name('experiments.store');
        Route::get('/experiments/{experiment}/edit', [ExperimentController::class, 'edit'])->name('experiments.edit');
        Route::put('/experiments/{experiment}', [ExperimentController::class, 'update'])->name('experiments.update');
        Route::delete('/experiments/{experiment}', [ExperimentController::class, 'destroy'])->name('experiments.destroy');

        Route::get('/experiments/{experiment}/questions', [QuestionController::class, 'index'])->name('experiments.questions.index');
        Route::get('/experiments/{experiment}/questions/create', [QuestionController::class, 'create'])->name('experiments.questions.create');
        Route::post('/experiments/{experiment}/questions', [QuestionController::class, 'store'])->name('experiments.questions.store');
        Route::get('/experiments/{experiment}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('experiments.questions.edit');
        Route::put('/experiments/{experiment}/questions/{question}', [QuestionController::class, 'update'])->name('experiments.questions.update');
        Route::delete('/experiments/{experiment}/questions/{question}', [QuestionController::class, 'destroy'])->name('experiments.questions.destroy');
    });
});

require __DIR__.'/auth.php';

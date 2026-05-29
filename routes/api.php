<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExperimentApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/experiments', [ExperimentApiController::class, 'index']);
    Route::get('/experiments/{id}', [ExperimentApiController::class, 'show']);
    Route::post('/experiments/{id}/progress', [ExperimentApiController::class, 'submitProgress']);
});

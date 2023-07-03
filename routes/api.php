<?php

use App\Http\Controllers\Api\{
    EvaluationController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json(['message' => 'success']));

Route::get('evaluations/{company}', [EvaluationController::class, 'index']);
Route::post('evaluations/{company}', [EvaluationController::class, 'store']);

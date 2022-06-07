<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Api\StepController;
use App\Http\Controllers\Api\SnippetController;
use App\Http\Controllers\Api\MySnippetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('token', function (Request $request) {
//     $token = User::first()->createToken($request->name ?? 'test');

//     return ['token' => $token->plainTextToken];
// });



Route::controller(MeController::class)->prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'me');
});

Route::controller(SnippetController::class)->prefix('snippets')->group(function () {
    Route::get('/', 'index');
    Route::get('/me', 'index');
    Route::get('/{snippet}', 'show');
    Route::post('/', 'store');
    Route::patch('/{snippet}', 'update');
    Route::delete('{snippet}', 'destroy');
});

Route::controller(MySnippetController::class)->group(function () {
    Route::get('/my-snippets', 'index');
});

Route::controller(StepController::class)->group(function () {
    Route::post('snippets/{snippet}/steps', 'store');
    Route::patch('snippets/{snippet}/steps/{step}', 'update');
    Route::delete('snippets/{snippet}/steps/{step}', 'destroy');
});

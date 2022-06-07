<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;

Route::get('user', [MeController::class,'me']);

require_once __DIR__ . '/fortify.php';

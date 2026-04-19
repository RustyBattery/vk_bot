<?php

use App\Http\Controllers\CallbackController;
use App\Http\Middleware\CallbackMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'vk_bot';
});

Route::post('/callback', [CallbackController::class, 'handle'])->middleware(CallbackMiddleware::class);

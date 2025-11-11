<?php

use App\Http\Controllers\Api\V1\FieldDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'message' => 'this is where I am',
    ], 200);
});

Route::post('/field-data', [FieldDataController::class, 'store'])
    ->name('api.v1.field-data.store');

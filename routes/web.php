<?php
use App\Http\Controllers\StudentTimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/times', [StudentTimeController::class, 'index']);
Route::post('/times/start', [StudentTimeController::class, 'start']);
Route::post('/times/stop/{id}', [StudentTimeController::class, 'stop']);

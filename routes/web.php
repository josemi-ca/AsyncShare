<?php

use App\Http\Controllers\ProcessRecordingController;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload-recording', ProcessRecordingController::class)->name('upload-recording');

Route::get('/view-recording', function (Request $request) {
    $video = Video::where('uid', $request->uid)->first();
    return view('player')->with(compact('video'));
})->name('view-recording');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

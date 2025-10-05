<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/punch/records/store', [AttendanceController::class, 'store']);
Route::get('/punch/records/store', function () {
    return redirect('/');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('API')->group(function () {
    Route::post('user/register','ApiAuthController@register');
    Route::post('user/login','ApiAuthController@login');
});

Route::namespace('API')->middleware('auth:user')->group(function () {
    Route::apiResource('states', 'StateController');
    Route::apiResource('patients', 'PatientController');
    Route::apiResource('specialties', 'SpecialtyController');
    Route::apiResource('doctors', 'DoctorController');
    Route::apiResource('appointments', 'AppointmentController');
    Route::apiResource('invoices', 'InvoiceController');
    Route::apiResource('admins', 'AdminController');

    Route::get('user/logout','ApiAuthController@logout');
});


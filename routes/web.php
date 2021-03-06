<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    // Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/appointments', 'admin.appointment-list')->name('admin.appointments');
    // Route::view('/specialities', 'admin.specialities')->name('admin.specialities');
    Route::view('/doctors', 'admin.doctors')->name('admin.doctors');
    // Route::view('/patients', 'admin.patients')->name('admin.patients');
    Route::view('/reviews', 'admin.reviews')->name('admin.reviews');
    Route::view('/transactions', 'admin.transactions')->name('admin.transactions');
    Route::view('/settings', 'admin.settings')->name('admin.settings');
    Route::view('/invoice-report', 'admin.invoice-report')->name('admin.invoice-report');
    Route::view('/profile', 'admin.profile')->name('admin.profile');

    // Route::view('/login', 'admin.login')->name('admin.login');
    Route::view('/register', 'admin.register')->name('admin.register');
    Route::view('/forgot-password', 'admin.forgot-password')->name('admin.forgot-password');
    Route::view('/lock-screen', 'admin.lock-screen')->name('admin.lock-screen');

    Route::view('/error-404', 'admin.error-404')->name('admin.error-404');
    Route::view('/error-500', 'admin.error-500')->name('admin.error-500');

    Route::view('/blank', 'admin.temp')->name('admin.blank');

    Route::view('/components', 'admin.components')->name('admin.components');
    Route::view('/tables-basic', 'admin.tables-basic')->name('admin.tables-basic');
    Route::view('/data-tables', 'admin.data-tables')->name('admin.data-tables');

    Route::view('/form-basic-inputs', 'admin.form-basic-inputs')->name('admin.form-basic-inputs');
    Route::view('/form-input-groups', 'admin.form-input-groups')->name('admin.form-input-groups');
    Route::view('/form-horizontal', 'admin.form-horizontal')->name('admin.form-horizontal');
    Route::view('/form-vertical', 'admin.form-vertical')->name('admin.form-vertical');
    Route::view('/form-mask', 'admin.form-mask')->name('admin.form-mask');
    Route::view('/form-validation', 'admin.form-validation')->name('admin.form-validation');
});

Route::prefix('cms/doctor')->group(function () {
    Route::view('/', 'doctor.dashboard')->name('doctor.dashboard');
    Route::view('/appointments', 'doctor.appointments')->name('doctor.appointments');
    Route::view('/my-patients', 'doctor.my-patients')->name('doctor.my-patients');
    Route::view('/schedule-timings', 'doctor.schedule-timings')->name('doctor.schedule-timings');
    Route::view('/invoices', 'doctor.invoices')->name('doctor.invoices');
    Route::view('/invoice-view', 'doctor.invoice-view')->name('doctor.invoice-view');
    Route::view('/reviews', 'doctor.reviews')->name('doctor.reviews');
    Route::view('/profile-settings', 'doctor.profile-settings')->name('doctor.profile-settings');
    Route::view('/social-media', 'doctor.social-media')->name('doctor.social-media');
    Route::view('/change-password', 'doctor.change-password')->name('doctor.change-password');
//    Route::view('/', 'doctor.parent')->name('doctor.dashboard');
});

Route::prefix('cms/patient')->group(function () {
    Route::view('/', 'patient.dashboard')->name('patient.dashboard');
    Route::view('/change-password', 'patient.change-password')->name('patient.change-password');
    Route::view('/profile-settings', 'patient.profile-settings')->name('patient.profile-settings');
    Route::view('/favourites', 'patient.favourites')->name('patient.favourites');
});




// Route::prefix('test/age')->middleware('Check_Age:22')->group(function () {
// Route::get('first', function () {
//     return "Age is accepted";
// });
// Route::get('second', function () {
//     return "Age is accepted";
// });
// });
Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');
});
Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::get('/logout','Auth\AdminAuthController@logout')->name('admin.logout');
});

Route::prefix('cms/admin')->group(function () {
    Route::get('/login', 'Auth\AdminAuthController@showLoginView')->name('admin.login_view');
    Route::post('/login','Auth\AdminAuthController@login')->name('admin.login');
});


Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::resource('admins','AdminController');
    Route::resource('cities','CityController');
    Route::resource('states','StateController');
    Route::resource('patients','PatientController');
    Route::resource('specialties','SpecialtyController');
    Route::resource('doctors','DoctorController');
    Route::resource('appointments','AppointmentController');
    Route::resource('invoices','InvoiceController');

});
Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::get('cities/{id}/states','CityController@showStates')->name('cities.states');
});


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

Route::get('/', function () {
    return view('department');
});

Route::get('/department', function () {
    return view('department');
});


Route::get('/employee', function () {
    return view('employee');
});

Route::get('/payroll', function () {
    return view('payroll');
});

Route::get('/earning', function () {
    return view('earning');
});


Route::get('/earning-type', function () {
    return view('earning_type');
});

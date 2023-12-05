<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/', function () {
        return redirect()->route('tickets.index');
    });
    
    Route::resource('tickets', TicketController::class);
    Route::get('tickets/edit/{parameter?}', [TicketController::class, 'edit'])->name('ticket-edit');

    Route::resource('companies', CompanyController::class);
    Route::get('companies/edit/{parameter?}', [CompanyController::class, 'edit'])->name('company-edit');

    Route::resource('companyUsers', CompanyUserController::class);
    Route::get('companyUsers/edit/{parameter?}', [CompanyUserController::class, 'edit'])->name('companyUsers-edit');
});
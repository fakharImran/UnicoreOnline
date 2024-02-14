<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
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


Route::get('/',  function(){
    $user = Auth::user();

if ($user) {
    switch (true) {
        case $user->roles->contains('name', 'admin'):
            // User has an "admin" role
            // Handle admin-specific actions
            return redirect()->route('companyUsers.index');
            break;

        

        case $user->roles->contains('name', 'user'):
            // User has a "manager" role
            // Handle manager-specific actions
            return redirect()->route('tickets.index');
            break;
            

        default:
            // User has other or no roles
            // Handle other user roles or cases
            Session::flush();
            Auth::logout();
            return redirect('login'); // Handle unknown roles appropriately

            break;
    }
} else {
    // Handle the case where no user is authenticated
    return redirect('/login'); // Handle unknown roles appropriately

}

    
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    // Route::get('/', function () {
    //     return redirect()->route('tickets.index');
    // });
    
    Route::resource('tickets', TicketController::class);
    Route::get('tickets/edit/{parameter?}', [TicketController::class, 'edit'])->name('ticket-edit');

    Route::resource('companies', CompanyController::class);
    Route::get('companies/edit/{parameter?}', [CompanyController::class, 'edit'])->name('company-edit');

    // Route::resource('comments', CommentController::class);
    Route::post('/comments/store', [ CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/delete', [ CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/update', [ CommentController::class, 'update'])->name('comments.update');

    Route::resource('companyUsers', CompanyUserController::class);
    Route::get('companyUsers/edit/{parameter?}', [CompanyUserController::class, 'edit'])->name('companyUsers-edit');
});
<?php

use App\Http\Controllers\Frontend\AuthenticationController;
use App\Http\Middleware\CheckNoOfCompaniesBelongToUser;
use App\Livewire\CompanyList;
use App\Livewire\CompanyRegistrationForm;
use App\Livewire\JobPost;
use App\Livewire\Login;
use App\Livewire\UserRegister;
use App\Livewire\UserRegisterForm;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('login-test', Login::class)->name('login');
Route::get('/register', UserRegisterForm::class)->name('register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', function(){
        auth()->logout();
        session()->flush();
        return to_route('home');
    })->name('logout');

    Route::get('create-company', CompanyRegistrationForm::class)->name('create.company')->middleware(CheckNoOfCompaniesBelongToUser::class);
    Route::get('companies', CompanyList::class)->name('companies');

    Route::get('post-job', JobPost::class)->name('post.job');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

<?php

use App\Http\Controllers\Frontend\ApplicationController;
use App\Http\Middleware\CheckNoOfCompaniesBelongToUser;
use App\Livewire\CompanyList;
use App\Livewire\CompanyRegistrationForm;
use App\Livewire\CreateResume;
use App\Livewire\EditResume;
use App\Livewire\HomePage;
use App\Livewire\JobList;
use App\Livewire\JobPost;
use App\Livewire\Login;
use App\Livewire\ShowJob;
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

Route::get('/', HomePage::class)->name('home');

Route::get('login-test', Login::class)->name('login');
Route::get('/register', UserRegisterForm::class)->name('register');
Route::get('job-details/{job}/{company}', ShowJob::class)->name('job.details');

Route::get('jobs', JobList::class);

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', function () {
        auth()->logout();
        session()->flush();

        return to_route('home');
    })->name('logout');

    Route::get('create-company', CompanyRegistrationForm::class)->name('create.company')->middleware([CheckNoOfCompaniesBelongToUser::class, 'role:employer']);
    Route::get('companies', CompanyList::class)->name('companies');

    Route::get('post-job', JobPost::class)->name('post.job');
    Route::get('job-list', JobList::class)->name('list.job');
    Route::get('create-resume', CreateResume::class)->name('create.resume');
    Route::get('edit-resume/{resume}', EditResume::class)->name('edit.resume');
    Route::get('apply/{job}', [ApplicationController::class, 'apply'])->name('apply');
});

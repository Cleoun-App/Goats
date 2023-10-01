<?php

use App\Http\Livewire\Dashboard\AppPages\ConfigPage\ConfigPage;
use App\Http\Livewire\Dashboard\AppPages\LoggerPage\LoggerPage;
use App\Http\Livewire\Dashboard\AppPages\NotificationPage\NotificationPage;
use App\Http\Livewire\Dashboard\AuthPage\LoginPage\LoginPage;
use App\Http\Livewire\Dashboard\HomePage\HomePage;
use App\Http\Livewire\Dashboard\ProfilePage\AccountPage\AccountPage;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\AuthPage\ForgotPassPage\ForgotPassPage;
use App\Http\Livewire\Dashboard\AuthPage\RegistrationPage\RegistrationPage;
use App\Http\Livewire\Dashboard\UserPages\UserAccountPage\UserAccountPage;
use App\Http\Livewire\Dashboard\UserPages\UserActivityPage\UserActivityPage;
use App\Http\Livewire\Dashboard\UserPages\UserCreatePage\UserCreatePage;
use App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserPermissionPage\UserPermissionPage;
use App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserRolePage\UserRolePage;
use App\Http\Livewire\Dashboard\UserPages\UserTablePage\UserTablePage;

/*
|--------------------------------------------------------------------------
| Web Routesq
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function () {

    Route::get('/login', LoginPage::class)->name('login');

    Route::get('/forgot-password', ForgotPassPage::class)->name('f-password');

    Route::get('/registration', RegistrationPage::class)->name('registration');

    // ...
});


Route::middleware(['auth', 'role:user|admin|supreme'])->group(function () {

    Route::get('/', HomePage::class)->name('ds.home_page');

    Route::get('/profil/akun', AccountPage::class)->name('ds.account_page');

    Route::get('/user/create', UserCreatePage::class)->name('ds.user.create');

    Route::get('/tabel/pengguna', UserTablePage::class)->name('ds.users.table');

    Route::get('/user/{username}/show', UserAccountPage::class)->name('ds.user.show');

    Route::get('/user/{username}/activities', UserActivityPage::class)->name('ds.user.activities');

    Route::get('/management/roles', UserRolePage::class)->name('ds.user.mgt.roles');

    Route::get('/management/permissions', UserPermissionPage::class)->name('ds.user.mgt.permissions');
    
    Route::get('/app/config', ConfigPage::class)->name('ds.app.config');

    Route::get('/webx/notification', NotificationPage::class)->name('ds.app.notification');

    Route::get('/webx/logger', LoggerPage::class)->name('ds.app.logger');

    Route::get('/f/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    // ...
});

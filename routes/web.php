<?php

use App\Http\Controllers\Reports\PDFReport;
use App\Http\Livewire\Dashboard\AppPages\NotificationPage\NotificationPage;
use App\Http\Livewire\Dashboard\AuthPage\LoginPage\LoginPage;
use App\Http\Livewire\Dashboard\HomePage\HomePage;
use App\Http\Livewire\Dashboard\ProfilePage\AccountPage\AccountPage;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\AuthPage\ForgotPassPage\ForgotPassPage;
use App\Http\Livewire\Dashboard\AuthPage\RegistrationPage\RegistrationPage;
use App\Http\Livewire\Dashboard\AuthPage\ResetPasswordPage\ResetPasswordPage;
use App\Http\Livewire\Dashboard\EventPages\EventsTablePage\EventsTablePage;
use App\Http\Livewire\Dashboard\EventPages\EventTypesTablePage\EventTypesTablePage;
use App\Http\Livewire\Dashboard\GoatPages\GoatsTablePage\GoatsTablePage;
use App\Http\Livewire\Dashboard\MilknotePages\MilknoteTablePage\MilknoteTablePage;
use App\Http\Livewire\Dashboard\UserPages\UserAccountPage\UserAccountPage;
use App\Http\Livewire\Dashboard\UserPages\UserCreatePage\UserCreatePage;
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
    
    Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');

    Route::get('/registration', RegistrationPage::class)->name('registration');

    // ...
});


Route::middleware(['auth', 'role:user|admin|supreme'])->group(function () {

    Route::get('/home', HomePage::class);

    Route::get('/', HomePage::class)->name('ds.home_page');

    Route::get('/profil/akun', AccountPage::class)->name('ds.account_page');

    Route::get('/user/create', UserCreatePage::class)->name('ds.user.create');

    Route::get('/tabel/pengguna', UserTablePage::class)->name('ds.users.table');
    
    Route::get('/tabel/goat', GoatsTablePage::class)->name('ds.goats.table');
    
    Route::get('/tabel/event', EventsTablePage::class)->name('ds.event.table');
    
    Route::get('/tabel/milknote', MilknoteTablePage::class)->name('ds.event.table');
    
    Route::get('/tabel/jenis/event', EventTypesTablePage::class)->name('ds.event.types.table');

    Route::get('/user/{username}/show', UserAccountPage::class)->name('ds.user.show');

    Route::get('/management/roles', UserRolePage::class)->name('ds.user.mgt.roles');

    Route::get('/webx/notification', NotificationPage::class)->name('ds.app.notification');

    Route::get('/user/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');


    Route::get('report/{report_model}/export/pdf', [PDFReport::class, 'export'])->name('ds.report.export.pdf');
    
    Route::get('report/{report_model}/preview/pdf', [PDFReport::class, 'preview'])->name('ds.report.preview.pdf');

    // ...
});

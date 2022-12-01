<?php

use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceCategoryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PenanggungJawabController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth')->group(function () {
    // ============================= DASHBOARD =========================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
	Route::get('/barang-masuk/form/{barang_masuk}', [BarangMasukController::class, 'form'])->name('barang-masuk.form');


    Route::middleware('can:viewAny, App\Models\User')->group(function () {
        // ============================ BARANG MASUK =======================================
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-masuk/{barang_masuk}', [BarangMasukController::class, 'show'])->name('barang-masuk.show');
	Route::get('/barang-masuk/edit/{barang_masuk}', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
        Route::post('/barang-masuk/form', [BarangMasukController::class, 'formPost'])->name('barang-masuk.formPost');
        Route::delete('/barang-masuk/{barang_masuk}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');


        // ============================ BARANG KELUAR =======================================
        Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
        Route::get('/barang-keluar/export', [BarangKeluarController::class, 'exportExcel'])->name('barang-keluar.export');
	Route::get('/barang-keluar/exportAsnet', [BarangKeluarController::class, 'exportExcelAsnet'])->name('barang-keluar.exportAsnet');
        Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
        Route::get('/barang-keluar/{barang_keluar}', [BarangKeluarController::class, 'show'])->name('barang-keluar.show');
	Route::delete('/barang-keluar/{barang_keluar}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');
        Route::delete('/barang-keluar', [BarangKeluarController::class, 'undo'])->name('barang-keluar.undo');
        // =============================== HISTORY ===========================================
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/{history}', [HistoryController::class, 'show'])->name('history.show');
	Route::delete('/history/{history}', [HistoryController::class, 'destroy'])->name('barang-masuk-history.destroy');


        // =============================== DEVICE ===========================================
        Route::get('/device', [DeviceCategoryController::class, 'index'])->name('device.index');
        Route::post('/device', [DeviceCategoryController::class, 'store'])->name('device.store');
        Route::delete('/device/{device}', [DeviceCategoryController::class, 'destroy'])->name('device.destroy');
    });



    // ========================== PENANGGUNG JAWAB ======================================
    Route::get('/penanggung-jawab', [PenanggungJawabController::class, 'index'])->name('penanggung-jawab.index');
    Route::post('/penanggung-jawab', [PenanggungJawabController::class, 'store'])->name('penanggung-jawab.store');
    Route::delete('/penanggung-jawab/{penanggung_jawab}', [PenanggungJawabController::class, 'destroy'])->name('penanggung-jawab.destroy');






    // ============================= LOGOUT ============================================
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});


Route::middleware('admin')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware('guest')->group(function () {

    // ============================= LOGIN =============================================
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/authentication', [LoginController::class, 'authenticate'])->name('login.authentication');
});

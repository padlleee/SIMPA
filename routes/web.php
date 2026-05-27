<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnakAsuhController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PendaftaranAnakController;
use App\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

// FAQ Public Page (dynamic — data from DB)
Route::get('/faq', [FaqController::class, 'publicIndex'])->name('faq');

// Public Donation Form (No Authentication Required)
Route::get('/form-donasi', [DonasiController::class, 'publicCreate'])->name('donasi.publicCreate');
Route::post('/form-donasi', [DonasiController::class, 'publicStore'])->name('donasi.publicStore');
Route::get('/donasi-sukses', [DonasiController::class, 'publicSuccess'])->name('donasi.public.success');

// Public Library View
Route::get('/perpustakaan-publik', [PerpustakaanController::class, 'publicIndex'])->name('perpustakaan.public.index');

// Public Account Request
Route::get('/minta-akun', [AccountRequestController::class, 'publicCreate'])->name('account-request.create');
Route::post('/minta-akun', [AccountRequestController::class, 'publicStore'])->name('account-request.store');

// Tentang Kami
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

// Blog / Kegiatan (Public)
Route::get('/blog', [ArticleController::class, 'publicIndex'])->name('blog.index');
Route::get('/blog/{slug}', [ArticleController::class, 'publicShow'])->name('blog.show');

// Pendaftaran Anak Asuh (Public)
Route::get('/pendaftaran-anak', [PendaftaranAnakController::class, 'create'])->name('pendaftaran-anak.create');
Route::post('/pendaftaran-anak', [PendaftaranAnakController::class, 'store'])->name('pendaftaran-anak.store');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Password Management (First-Login & User-Initiated)
Route::middleware(['auth'])->group(function () {
    Route::get('/ubah-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/ubah-password', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/ubah-password-sukses', [AuthController::class, 'passwordChangeSuccess'])->name('password.success');

    // Shared Donasi Routes
    Route::get('/donasi/{donasi}/kwitansi', [DonasiController::class, 'showReceipt'])->name('donasi.receipt');
    Route::get('/donasi/{donasi}/kwitansi/download', [DonasiController::class, 'downloadReceipt'])->name('donasi.receipt.download');
});

/*
|--------------------------------------------------------------------------
| ADMIN & KETUA – Full Management Access
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin,Ketua,Bendahara'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Anak Asuh
    Route::get('/anak-asuh', [AnakAsuhController::class, 'index'])->name('anak-asuh.index');
    Route::get('/anak-asuh/create', [AnakAsuhController::class, 'create'])->name('anak-asuh.create');
    Route::post('/anak-asuh', [AnakAsuhController::class, 'store'])->name('anak-asuh.store');
    Route::get('/anak-asuh/{anakAsuh}', [AnakAsuhController::class, 'show'])->name('anak-asuh.show');
    Route::get('/anak-asuh/{anakAsuh}/edit', [AnakAsuhController::class, 'edit'])->name('anak-asuh.edit');
    Route::put('/anak-asuh/{anakAsuh}', [AnakAsuhController::class, 'update'])->name('anak-asuh.update');
    Route::delete('/anak-asuh/{anakAsuh}', [AnakAsuhController::class, 'destroy'])->name('anak-asuh.destroy');
    Route::patch('/anak-asuh/{anakAsuh}/toggle-status', [AnakAsuhController::class, 'toggleStatus'])->name('anak-asuh.toggle-status');

    // Donasi
    Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/create-tunai', [DonasiController::class, 'adminCreate'])->name('donasi.adminCreate');
    Route::post('/donasi/store-tunai', [DonasiController::class, 'adminStore'])->name('donasi.adminStore');
    Route::get('/donasi/{donasi}', [DonasiController::class, 'show'])->name('donasi.show');
    Route::patch('/donasi/{donasi}/verify', [DonasiController::class, 'verify'])->name('donasi.verify');
    Route::patch('/donasi/{donasi}/reject', [DonasiController::class, 'reject'])->name('donasi.reject');
    Route::delete('/donasi/{donasi}', [DonasiController::class, 'destroy'])->name('donasi.destroy');

    // Stok Panti (Gudang)
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/stok/riwayat', [RiwayatStokController::class, 'index'])->name('stok.riwayat');
    Route::get('/stok/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/stok', [StokController::class, 'store'])->name('stok.store');
    Route::get('/stok/{stok}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/stok/{stok}', [StokController::class, 'update'])->name('stok.update');
    Route::delete('/stok/{stok}', [StokController::class, 'destroy'])->name('stok.destroy');

    // Inventaris Peralatan
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/{inventari}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
    Route::put('/inventaris/{inventari}', [InventarisController::class, 'update'])->name('inventaris.update');
    Route::delete('/inventaris/{inventari}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');

    // Perpustakaan
    Route::get('/perpustakaan', [PerpustakaanController::class, 'index'])->name('perpustakaan.index');
    Route::get('/perpustakaan/create', [PerpustakaanController::class, 'create'])->name('perpustakaan.create');
    Route::get('/perpustakaan/riwayat', [PerpustakaanController::class, 'riwayat'])->name('perpustakaan.riwayat');
    Route::post('/perpustakaan', [PerpustakaanController::class, 'store'])->name('perpustakaan.store');
    Route::get('/perpustakaan/{perpustakaan}', [PerpustakaanController::class, 'show'])->name('perpustakaan.show');
    Route::get('/perpustakaan/{perpustakaan}/edit', [PerpustakaanController::class, 'edit'])->name('perpustakaan.edit');
    Route::put('/perpustakaan/{perpustakaan}', [PerpustakaanController::class, 'update'])->name('perpustakaan.update');
    Route::delete('/perpustakaan/{perpustakaan}', [PerpustakaanController::class, 'destroy'])->name('perpustakaan.destroy');
    Route::get('/perpustakaan/{perpustakaan}/pinjam', [PerpustakaanController::class, 'pinjamCreate'])->name('perpustakaan.pinjam');
    Route::post('/perpustakaan/{perpustakaan}/pinjam', [PerpustakaanController::class, 'pinjamStore'])->name('perpustakaan.pinjam.store');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PerpustakaanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Pengeluaran
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'show'])->name('pengeluaran.show');
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Account Requests (Admin)
    Route::get('/account-requests', [AccountRequestController::class, 'index'])->name('account-request.index');
    Route::patch('/account-requests/{accountRequest}/approve', [AccountRequestController::class, 'approve'])->name('account-request.approve');
    Route::patch('/account-requests/{accountRequest}/reject', [AccountRequestController::class, 'reject'])->name('account-request.reject');

    // Blog / Kegiatan (Admin CRUD)
    Route::get('/admin/blog', [ArticleController::class, 'adminIndex'])->name('admin.blog.index');
    Route::get('/admin/blog/create', [ArticleController::class, 'create'])->name('admin.blog.create');
    Route::post('/admin/blog', [ArticleController::class, 'store'])->name('admin.blog.store');
    Route::delete('/admin/blog/{article}', [ArticleController::class, 'destroy'])->name('admin.blog.destroy');

    // FAQ (Admin CRUD)
    Route::get('/admin/faq', [FaqController::class, 'adminIndex'])->name('admin.faq.index');
    Route::get('/admin/faq/create', [FaqController::class, 'create'])->name('admin.faq.create');
    Route::post('/admin/faq', [FaqController::class, 'store'])->name('admin.faq.store');
    Route::get('/admin/faq/{faq}/edit', [FaqController::class, 'edit'])->name('admin.faq.edit');
    Route::put('/admin/faq/{faq}', [FaqController::class, 'update'])->name('admin.faq.update');
    Route::delete('/admin/faq/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');

    // Pendaftaran Anak Asuh (Admin Review)
    Route::get('/admin/pendaftaran-requests', [PendaftaranAnakController::class, 'adminIndex'])->name('admin.pendaftaran.index');
    Route::patch('/admin/pendaftaran-requests/{calon}/approve', [PendaftaranAnakController::class, 'approve'])->name('admin.pendaftaran.approve');
    Route::patch('/admin/pendaftaran-requests/{calon}/reject', [PendaftaranAnakController::class, 'reject'])->name('admin.pendaftaran.reject');
});


/*
|--------------------------------------------------------------------------
| DONATUR – Personal Dashboard Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Donatur'])->group(function () {
    Route::get('/donatur/dashboard', [DonaturController::class, 'dashboard'])->name('donatur.dashboard');
    Route::get('/donatur/profile', [DonaturController::class, 'profile'])->name('donatur.profile');
    Route::put('/donatur/profile', [DonaturController::class, 'profileUpdate'])->name('donatur.profile.update');

    // Donasi from registered Donatur
    Route::get('/donatur/laporan', [DonaturController::class, 'laporan'])->name('donatur.laporan');
    Route::get('/donatur/donasi/create', [DonasiController::class, 'userCreate'])->name('donatur.donasi.create');

    Route::post('/donatur/donasi', [DonasiController::class, 'userStore'])->name('donatur.donasi.store');
});

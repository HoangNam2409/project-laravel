<?php

use App\Http\Controllers\ajax\LocationController;
use App\Http\Controllers\ajax\MemberManagementController;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\LanguageController;
use App\Http\Controllers\backend\PostCatalogueController;
use App\Http\Controllers\backend\UserCatalogueController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\PermissionController;
use Illuminate\Support\Facades\Route;

// Permission Request
Route::prefix('permission')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('{id}/edit', [PermissionController::class, 'edit'])->where('id', '[0-9]+')->name('permission.edit');
    Route::post('{id}/update', [PermissionController::class, 'update'])->where('id', '[0-9]+')->name('permission.update');
    Route::get('{id}/delete', [PermissionController::class, 'delete'])->where('id', '[0-9]+')->name('permission.delete');
    Route::delete('{id}/destroy', [PermissionController::class, 'destroy'])->where('id', '[0-9]+')->name('permission.destroy');
});

// Post Request
Route::prefix('post')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [PostController::class, 'index'])->name('post.index');
    Route::get('create', [PostController::class, 'create'])->name('post.create');
    Route::post('store', [PostController::class, 'store'])->name('post.store');
    Route::get('{id}/edit', [PostController::class, 'edit'])->where('id', '[0-9]+')->name('post.edit');
    Route::post('{id}/update', [PostController::class, 'update'])->where('id', '[0-9]+')->name('post.update');
    Route::get('{id}/delete', [PostController::class, 'delete'])->where('id', '[0-9]+')->name('post.delete');
    Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where('id', '[0-9]+')->name('post.destroy');
});

// Post Catalogue Request
Route::prefix('post/catalogue')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
    Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
    Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
    Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where('id', '[0-9]+')->name('post.catalogue.edit');
    Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where('id', '[0-9]+')->name('post.catalogue.update');
    Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where('id', '[0-9]+')->name('post.catalogue.delete');
    Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where('id', '[0-9]+')->name('post.catalogue.destroy');
});

// User Catalogue Request
Route::prefix('user/catalogue')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
    Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
    Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where('id', '[0-9]+')->name('user.catalogue.edit');
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where('id', '[0-9]+')->name('user.catalogue.update');
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where('id', '[0-9]+')->name('user.catalogue.delete');
    Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where('id', '[0-9]+')->name('user.catalogue.destroy');
    Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
    Route::post('permission/update', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.update.permission');
});

// User Request
Route::prefix('user')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('user.index');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::get('{id}/edit', [UserController::class, 'edit'])->where('id', '[0-9]+')->name('user.edit');
    Route::post('{id}/update', [UserController::class, 'update'])->where('id', '[0-9]+')->name('user.update');
    Route::get('{id}/delete', [UserController::class, 'delete'])->where('id', '[0-9]+')->name('user.delete');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where('id', '[0-9]+')->name('user.destroy');
});

// Languages Request
Route::prefix('language')->middleware(['authenticate', 'locate'])->group(function () {
    Route::get('index', [LanguageController::class, 'index'])->name('language.index');
    Route::get('create', [LanguageController::class, 'create'])->name('language.create');
    Route::post('store', [LanguageController::class, 'store'])->name('language.store');
    Route::get('{id}/edit', [LanguageController::class, 'edit'])->where('id', '[0-9]+')->name('language.edit');
    Route::post('{id}/update', [LanguageController::class, 'update'])->where('id', '[0-9]+')->name('language.update');
    Route::get('{id}/delete', [LanguageController::class, 'delete'])->where('id', '[0-9]+')->name('language.delete');
    Route::delete('{id}/destroy', [LanguageController::class, 'destroy'])->where('id', '[0-9]+')->name('language.destroy');
    Route::get('{canonical}/switch', [LanguageController::class, 'switchBackendLanguage'])->where('id', '[A-Za-z]+')->name('language.switch');
});

// AJAX
Route::prefix('ajax')->group(function () {
    Route::get('location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.getLocation');
    Route::post('memberManagement/changeStatus', [MemberManagementController::class, 'changeStatus'])->name('ajax.memberManagement.changeStatus');
    Route::post('memberManagement/changeStatusAll', [MemberManagementController::class, 'changeStatusAll'])->name('ajax.memberManagement.changeStatusAll');
});


// Dashboard Request
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('authenticate', 'locate');

// Auth Request
Route::get('/admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

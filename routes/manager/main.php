<?php

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\ModuleController;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the prefix "admin" middleware group. Now create something great!
|
*/
//Backend Routes
Route::group(['middleware' => ['auth', 'verified', 'xss', 'user.status', 'user.module:manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Post Group
    Route::get('profile/{id}', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile-image/{id}', [ProfileController::class, 'getImage'])->name('profile.get.image');

    Route::resource('post', \App\Http\Controllers\Manager\post\postController::class);
    Route::get('get-post', [\App\Http\Controllers\Manager\post\postController::class, 'getIndex'])->name('get.post');
    Route::get('get-post-select', [\App\Http\Controllers\Manager\post\postController::class, 'getIndexSelect'])->name('get.post-select');
    Route::get('get-post-activity/{id}', [\App\Http\Controllers\Manager\post\postController::class, 'getActivity'])->name('get.post-activity');
    Route::get('get-post-activity-log/{id}', [\App\Http\Controllers\Manager\post\postController::class, 'getActivityLog'])->name('get.post-activity-log');
    Route::get('get-post-activity-trash', [\App\Http\Controllers\Manager\post\postController::class, 'getTrashActivity'])->name('get.post-activity-trash');
    Route::get('get-post-activity-trash-log', [\App\Http\Controllers\Manager\post\postController::class, 'getTrashActivityLog'])->name('get.post-activity-trash-log');

    //category

    Route::resource('category', \App\Http\Controllers\Manager\category\CategoryController::class);
    Route::get('get-category', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getIndex'])->name('get.category');
    Route::get('get-category-select', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getIndexSelect'])->name('get.category-select');
    Route::get('get-category-activity/{id}', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getActivity'])->name('get.category-activity');
    Route::get('get-category-activity-log/{id}', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getActivityLog'])->name('get.category-activity-log');
    Route::get('get-category-activity-trash', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getTrashActivity'])->name('get.category-activity-trash');
    Route::get('get-category-activity-trash-log', [\App\Http\Controllers\Manager\category\CategoryController::class, 'getTrashActivityLog'])->name('get.category-activity-trash-log');


});



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
    //Permission Group
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Permission Group
    Route::get('profile/{id}', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile-image/{id}', [ProfileController::class, 'getImage'])->name('profile.get.image');

    Route::resource('crud', \App\Http\Controllers\Manager\Crud\CrudController::class);
    Route::get('get-crud', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getIndex'])->name('get.crud');
    Route::get('get-crud-select', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getIndexSelect'])->name('get.crud-select');
    Route::get('get-crud-activity/{id}', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getActivity'])->name('get.crud-activity');
    Route::get('get-crud-activity-log/{id}', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getActivityLog'])->name('get.crud-activity-log');
    Route::get('get-crud-activity-trash', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getTrashActivity'])->name('get.crud-activity-trash');
    Route::get('get-crud-activity-trash-log', [\App\Http\Controllers\Manager\Crud\CrudController::class, 'getTrashActivityLog'])->name('get.crud-activity-trash-log');
});



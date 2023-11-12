<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


Route::middleware('admin')->prefix('dashboard')->group(function () {
    Route::redirect('/', '/dashboard/quotes');

    Route::controller(QuoteController::class)->prefix('/quotes')->name('quotes.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/search', 'dashboardSearch')->name('dashboard.search');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(TermController::class)->prefix('/terms')->name('terms.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(KnowledgeController::class)->prefix('/knowledge')->name('knowledge.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/edit-nestedset', 'editNestedset')->name('edit-nestedset');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/update-nestedset', 'updateNestedset')->name('update-nestedset');
    });

    Route::controller(VideoController::class)->prefix('/videos')->name('videos.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(PhotoController::class)->prefix('/photos')->name('photos.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(CategoryController::class)->prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::get('/edit-nestedset', 'editNestedset')->name('edit-nestedset');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/update-nestedset', 'updateNestedset')->name('update-nestedset');
    });

    Route::controller(AuthorController::class)->prefix('/authors')->name('authors.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(ChannelController::class)->prefix('/channels')->name('channels.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::get('/trash', 'dashboardTrash')->name('dashboard.trash');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::controller(UserController::class)->prefix('/users')->name('users.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::controller(FeedbackController::class)->prefix('/feedbacks')->name('feedbacks.')->group(function () {
        Route::get('/', 'dashboardIndex')->name('dashboard.index');
        Route::post('/destroy', 'destroy')->name('destroy');
    });
});

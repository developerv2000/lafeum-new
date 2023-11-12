<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VocabularyController;
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

Route::middleware('verified')->group(function () {
    Route::controller(AppController::class)->group(function () {
        Route::get('/', 'home')->name('home')->middleware('verified');
        Route::get('/contacts', 'contacts')->name('contacts');
        Route::get('/privacy-policy', 'policy')->name('policy');
        Route::get('/terms-of-use', 'termsOfUse')->name('terms-of-use');
    });

    Route::controller(KnowledgeController::class)->name('knowledge.')->group(function () {
        Route::get('/knowledge', 'index')->name('index');
        Route::get('/knowledge/{knowledge:slug}', 'show')->name('show');
    });

    Route::controller(VocabularyController::class)->name('vocabulary.')->group(function () {
        Route::get('/vocabulary', 'index')->name('index');
        Route::post('/vocabulary/get-body/{term}', 'getBody')->name('get-body'); // used in AJAX request
        Route::post('/vocabulary/filter', 'filter')->name('filter'); // used in AJAX request
    });

    Route::controller(QuoteController::class)->name('quotes.')->group(function () {
        Route::get('/quotes', 'index')->name('index');
        Route::get('/quote/{quote}', 'show')->name('show');
        Route::post('/quotes/filter', 'filter')->name('filter'); // used in AJAX request
    });

    Route::controller(AuthorController::class)->name('authors.')->group(function () {
        Route::get('/authors', 'index')->name('index');
        Route::get('/authors/{slug}', 'show')->name('show');
    });

    Route::controller(VideoController::class)->name('videos.')->group(function () {
        Route::get('/videos', 'index')->name('index');
        Route::get('/video/{video}', 'show')->name('show');
        Route::post('/videos/filter', 'filter')->name('filter'); // used in AJAX request
    });

    Route::controller(ChannelController::class)->name('channels.')->group(function () {
        Route::get('/channels', 'index')->name('index');
        Route::get('/channels/{channel:slug}', 'show')->name('show');
    });

    Route::controller(TermController::class)->name('terms.')->group(function () {
        Route::get('/terms', 'index')->name('index');
        Route::get('/term/{term}', 'show')->name('show');
        Route::post('/terms/filter', 'filter')->name('filter'); // used in AJAX request
    });

    Route::controller(PhotoController::class)->name('photos.')->group(function () {
        Route::get('/photos', 'index')->name('index');
        Route::get('/photo/{photo}', 'show')->name('show');
        Route::post('/photos/filter', 'filter')->name('filter'); // used in AJAX request
    });

    Route::controller(FeedbackController::class)->name('feedbacks.')->group(function () {
        Route::post('/feedbacks/store', 'store')->name('store');
    });

    Route::controller(ProfileController::class)->name('profile.')->middleware('auth')->group(function () {
        Route::get('/profile/edit', 'edit')->name('edit');
        Route::post('/profile/update', 'update')->name('update');
        Route::post('/profile/update-password', 'updatePassword')->name('update-password');
    });

    Route::controller(LikeController::class)->name('likes.')->group(function () {
        Route::get('/likes', 'index')->name('index');
        Route::post('/likes/toggle', 'toggle')->name('toggle');
    });

    Route::controller(FavoriteController::class)->name('favorites.')->group(function () {
        Route::get('/favorites', 'index')->name('index');
        Route::post('/favorites/toggle', 'toggle')->name('toggle');
    });

    Route::controller(FolderController::class)->name('folders.')->middleware('auth')->group(function () {
        Route::get('/folder/{id}', 'show')->name('show');
        Route::post('/folders/store', 'store')->name('store');
        Route::post('/folders/update', 'update')->name('update');
        Route::post('/folders/remove', 'remove')->name('remove');
        Route::post('/folders/upgrade', 'upgrade')->name('upgrade');
        Route::post('/folders/downgrade', 'downgrade')->name('downgrade');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';

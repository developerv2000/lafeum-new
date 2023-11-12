<?php

namespace App\Providers;

use App\Models\DailyPost;
use App\Support\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.navbar', function ($view) {
            $view->with('request', request());
        });

        View::composer('layouts.rightbar', function ($view) {
            $view->with('daily', DailyPost::orderBy('id', 'desc')->with(['quote', 'term', 'video', 'photo'])->first());
        });

        View::composer('leftbars.profile', function ($view) {
            $view->with('user', request()->user()->load('rootFolders'))
                ->with('routeName', Route::currentRouteName());
        });

        View::composer(['components.cards.partials.like-auth', 'components.cards.partials.favorite-auth'], function ($view) {
            $view->with('currentUser', request()->user());
        });

        View::composer('dashboard.*', function ($view) {
            $view->with('routeName', Route::currentRouteName())
                ->with('modelPrefixName', Helper::getModelPrefixName());;
        });
    }
}

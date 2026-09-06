<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AboutContent;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Har view ko $about variable automatically mil jayega
        View::composer('*', function ($view) {
            $view->with('about', AboutContent::first());
        });
    }
}

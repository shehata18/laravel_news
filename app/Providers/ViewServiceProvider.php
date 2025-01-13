<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewsSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $relatedSites = RelatedNewsSite::select('name','url')->get();



        $categories = Category::active()->select('id','slug','name')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();
        view()->share([
            'categories'=> $categories,
            'relatedSites'=>$relatedSites,
        ]);
    }
}

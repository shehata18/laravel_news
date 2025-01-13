<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // active is local scope for getting posts that have active status or 1
        $latest_posts = Post::active()->with('images')->latest()->paginate(9);

        $most_posts_views  = Post::active()->orderBy('num_of_views','desc')
            ->limit(3)
            ->get();

        $oldest_posts  = Post::active()->oldest()->limit(3)->get(); // orderBy 'created_at'
        $most_posts_comments = Post::active()->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(3)
            ->get();

        $categories = Category::has('posts','>=', 2)->active()->get(); // Collection
        $categories_with_posts = $categories->map(function($category){
            $category->posts = $category->posts()->active()->limit(4)->get();
            return $category;
        });

        return view('frontend.index', compact(
            'latest_posts',
            'most_posts_views',
            'oldest_posts',
            'most_posts_comments',
            'categories_with_posts'
        ));
    }
}

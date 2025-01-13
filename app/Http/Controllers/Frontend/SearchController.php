<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:300',
        ]);
        $keyword = strip_tags($request->search);
        $posts = Post::active()->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->paginate(3);

        return view('frontend.search', compact('posts','keyword'));

    }
}

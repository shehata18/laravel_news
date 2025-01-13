<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;
        $posts = Post::with(['user','category'])->when(request()->keyword, function ($query) {
            $query->where('title', 'like', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });
        $posts = $posts->orderBy($sort_by, $order_by)->paginate($limit_by);
//            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))
//            ->paginate(request('limit_by', 5));
        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        ImageManager::deleteImages($post);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post has been deleted');
    }

    public function changeStatus($id)
    {
        $post = Post::findOrFail($id);
        if($post->status == '1'){
            $post->update([
                'status' => 0,
            ]);
            Session::flash('success', 'Post has been blocked');
        }else{
            $post->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Post has been activated');
        }
        return redirect()->back();

    }
}

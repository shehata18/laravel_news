<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function show($slug)
    {
        $mainPost = Post::active()->with(['comments'=>function ($query) {
            $query->latest()->limit(3);
        }])->whereSlug($slug)->first();
        if (!$mainPost) {
            Session::flash('error', 'Post not active');
            return redirect()->back();
//            abort(404, 'Post not found or not active');
        }
        $category = $mainPost->category;
//        $belongs_to_category = Post::whereCategoryId($category->id)->get(); //  eloquent model method
        $posts_belongs_to_category = $category->posts()
            ->select('id','title','slug')
            ->limit(5)
            ->get();
        $mainPost->increment('num_of_views');
        return view('frontend.show')->with([
            'mainPost'=> $mainPost,
            'category' => $category,
            'posts_belongs_to_category' => $posts_belongs_to_category,
        ]); // same as compact() helper func

    }

    public function getAllPosts($slug)
    {
        $post = Post::active()->whereSlug($slug)->first();
        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function saveComment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:600',
            'post_id' => 'required|exists:posts,id',
        ]);
        Cache::forget('greatest_posts_comments');

        $comment =  Comment::create([
            'user_id' => $request->user_id,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
            'post_id' => $request->post_id,
        ]);

        $post = Post::findOrFail($request->post_id);
            // in case send notification to multiple users
//        $users = User::where('id', '!=', auth()->user()->id)->get();
//        Notification::send($users, new NewCommentNotify($comment,$post));

//        $user = $post->user;
        $postOwner = $post->user; // Get the post owner


        if ($postOwner->id !== $request->user_id) {
            $postOwner->notify(new NewCommentNotify($comment, $post));
        }



        $comment->load('user');
        if (!$comment){
            return response()->json([
                'data'=>'Operation Failed',
                'status'=>403
            ]);
        }
        return response()->json([
            'msg'=>'Comment added successfully!',
            'data' => $comment,
            'status' => 201
        ]);
    }
}

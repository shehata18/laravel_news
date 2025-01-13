<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Utils\ImageManager;
use App\Utils\PostCacheManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        // Get all auth user posts
        // $posts = Post::active()->with(['images'])->where('user_id', auth()->id())->get();
        // another way using relations
        $posts = auth()->user()->posts()->active()->with([ 'images' ])->latest()->get();
        return view('frontend.dashboard.profile', compact('posts'));
    }

    public function store(PostRequest $request)
    {
        $request->validated();
        try {
            // make query as a one unit
            DB::beginTransaction();
            $this->commentAble($request);
            $post = auth()->user()->posts()->create($request->except([ '_token', 'images' ])); // use relations
            // same as this
            // $request->merge(['user_id' => auth()->user()->id]);

            ImageManager::uploadImages($request, $post);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([ 'error' => $e->getMessage() ]);
        }


        Session::flash('success', 'Post Created Successfully');
        return redirect()->back();

//        $post = Post::create([
//            'title' => $request->title,
//            'description' => $request->description,
//            'comment_able' => $request->comment_able,
//            'user_id' => $request->user_id,
//            'category_id' => $request->category_id,
//
//        ]);

//        $post = Post::create($request->except(['_token', 'images']));
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->comment_able = $request->comment_able;
        $post->save();

    }


    public function editPost($slug)
    {
        return $slug;
    }

    public function deletePost(Request $request)
    {
        $post = Post::where('slug', $request->slug)->first();
        if (!$post) {
            abort(404);
        }

        ImageManager::deleteImages($post);
        $post->delete();
        return redirect()->back()->with('success', 'Post Deleted Successfully');
    }

    public function getComments($id)
    {
        $comments = Comment::with([
            'user'=> function ($query) {
                $query->select('id', 'name');
            }
        ])->where('post_id', $id)->get();

        if ($comments->isEmpty()) {
            return response()->json([
                'data' => null,
                'msg' => 'No Comments Found'
            ]);
        }
        return response()->json([
            'data' => $comments,
            'msg' => 'Comments Found'
        ]);
    }

    public function showEditForm($slug)
    {
        $post = Post::with('images')->whereSlug($slug)->first();
        if(!$post ){
            abort(404);
        }
        return view('frontend.dashboard.edit-post', compact('post'));
    }

    public function updatePost(PostRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $post = Post::findOrFail($request->post_id);
            $this->commentAble($request);
            $post->update($request->except([ '_token', 'images','_method', 'post_id' ]));

            // check if old post has image or no
            if ($request->hasFile('images')) {

                // Delete old images form local and database
                ImageManager::deleteImages($post);

                // Store New Images on local and database
                ImageManager::uploadImages($request, $post);
            }
            DB::commit();
        }

        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([ 'error' => $e->getMessage() ]);
        }

        Session::flash('success', 'Post Updated Successfully');
        return redirect()->route('frontend.dashboard.profile');
    }
    private function commentAble($request)
    {
        return $request->comment_able == 'on' ?
            $request->merge([ 'comment_able' => 1 ]) :
            $request->merge([ 'comment_able' => 0 ]);


    }

    public function deletePostImage(Request $request, $image_id)
    {
        $image = Image::find($request->key);
        if ( !$image){
            return response()->json([
                'data' => null,
                'msg' => 'Image Not Found',
                'status'=>'404'
            ]);
        }
        // delete Image form local
        ImageManager::deleteImageFromLocal($image->path);

        // delete Image form Database
        $image->delete();
        return response()->json([
            'msg' => 'Image Deleted Successfully',
            'status'=>'200'
        ]);

    }

}

<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;
        $categories = Category::withCount('posts')->when(request()->keyword, function ($query) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        })->when(!is_null(request()->post_count), function ($query) {
            $query->having('posts_count', '>=', request()->post_count);
        });;

        $categories = $categories->orderBy($sort_by, $order_by)->paginate($limit_by);
//            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))
//            ->paginate(request('limit_by', 5));
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50|unique:categories,name',
            'status' => 'required|in:0,1',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        if (!$category){
            Session::flash('error', 'Category could not be created.');
            return redirect()->back();
        }

        Session::flash('success', 'Category created successfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|min:2|max:50|unique:categories,name,'.$category->id,
            'status' => 'required|in:0,1',
        ]);
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        if (!$category){
            Session::flash('error', 'Category could not be updated.');
            return redirect()->back();
        }
        Session::flash('success', 'Category updated successfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('success', 'Category deleted successfully');
        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $category = Category::findOrFail($id);
        if($category->status == '1'){
            $category->update([
                'status' => 0,
            ]);
            Session::flash('success', 'Category has been deactivated');
        }else{
            $category->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Category has been activated');
        }
        return redirect()->back();

    }


}

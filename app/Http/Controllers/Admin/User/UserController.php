<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;
        $users = User::when(request()->keyword, function ($query) {
            $query->where('name', 'like', '%' . request()->keyword . '%')
                ->orWhere('email', 'like', '%' . request()->keyword . '%');

        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });
        $users = $users->orderBy($sort_by, $order_by)->paginate($limit_by);
//            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))
//            ->paginate(request('limit_by', 5));
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
            ]);
            $user = User::create($request->except(['_token','image','password_confirmation']));
            ImageManager::uploadImages($request, null, $user);
            DB::commit();

        }catch (\Exception $e ){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'User created successfully.');



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

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
    public function destroy(Request $request,string $id)
    {
        $user = User::findOrFail($id);
        ImageManager::deleteImageFromLocal($user->image);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User has been deleted');

    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        if($user->status == '1'){
            $user->update([
                'status' => 0,
            ]);
            Session::flash('success', 'User has been blocked');
        }else{
            $user->update([
                'status' => 1,
            ]);
            Session::flash('success', 'User has been activated');
        }
        return redirect()->back();

    }
}

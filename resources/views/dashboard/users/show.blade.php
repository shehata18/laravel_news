@extends('layouts.dashboard.app')@section('title', 'Show User ' . $user->name)
@section('body')
    <br>
    <center>
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body shadow mb-4 col-10">
                <h2 style="text-align: center">Show User " {{ $user->name }}"
                    <img class="img-thumbnail" src="{{ $user->image }}" width="70px" height="70px" alt="User-image">
                </h2><br><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input disabled type="text" value="{{ $user->name }}" name="name" class="form-control" placeholder="Enter Name of User">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input disabled type="text" value="{{ $user->username }}" name="username" class="form-control" placeholder="Enter username">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input disabled type="text" value="{{ $user->email }}" name="email" class="form-control" placeholder="Enter User Email">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input disabled type="text" value="{{ $user->phone }}" name="phone" class="form-control" placeholder="Enter User phone">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Status</label>
                            <input disabled type="text" value="@if( $user->status == 1) Active @else Not Active @endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Email Verified</label>

                            <input disabled type="text" value="@if( $user->email_verified_at) Verfied along {{ $user->email_verified_at->diffForHumans() }} @else Not Verified @endif" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Country</label>
                            <input disabled type="text" value="{{ $user->country }}" name="country" class="form-control" placeholder="Enter User Country Name">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">City</label>
                            <input disabled type="text" value="{{ $user->city }}" name="city" class="form-control" placeholder="Enter User City">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Street</label>
                            <input disabled type="text" value="{{ $user->street }}" name="street" class="form-control" placeholder="Enter User Street">
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-info" href="{{ route('admin.users.changeStatus', $user->id) }}"> {{ $user->status == 1 ? 'Block' : 'Active' }} </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-danger" href="javascript:void(0)" onclick="if(confirm('Do you want to delete the user')){ document.getElementById('delete_user').submit()} return false">
                    Delete</a></div>

        </form>
    </center>

    <form id="delete_user" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
        @csrf
        @method('DELETE')
    </form>
@endsection



@extends('layouts.dashboard.auth.app');

@section( 'title','Login' )

@section( 'body' )

    <div class="row justify-content-center">

        <div style="top: 80px" class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div style="bottom: 6px" class="col-lg-6 d-lg-block bg-login-image">
                            <img src="{{ asset('assets/admin/img/check.svg') }}" alt="login-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Enter your verification code</h1>
                                </div>
                                <form action="{{ route('admin.password.verifyOTP') }}" method="post" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input hidden="hidden" value="{{ $email }}" name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        @error( 'email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group position-relative">
                                        <input name="token" type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="Token">
                                        @error( 'token' )
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Check Token
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

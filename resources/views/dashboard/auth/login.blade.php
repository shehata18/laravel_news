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
                            <img src="{{ asset('assets/admin/img/login.svg') }}" alt="login-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form action="{{ route('admin.login.check') }}" method="post" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        @error( 'email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group position-relative">
                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        <i class="fa fa-eye position-absolute" id="togglePassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                                        @error( 'password' )
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('admin.password.email') }}">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection

@push('js')
    <script>

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('exampleInputPassword');
            const icon = this;
            const isPassword = passwordInput.type === 'password';

            // Toggle password visibility
            passwordInput.type = isPassword ? 'text' : 'password';

            // Change the icon
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });


    </script>

@endpush

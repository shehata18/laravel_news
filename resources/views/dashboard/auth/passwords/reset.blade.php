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
                            <img src="{{ asset('assets/admin/img/confirm.svg') }}" alt="login-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back! <br> 🔷 Reset Password 🔷</h1>
                                </div>

                                <form action="{{ route('admin.password.reset') }}" method="post" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input hidden="hidden" name="email" value="{{ $email }}" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group position-relative">
                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="New Password">
                                        <i class="fa fa-eye position-absolute toggle-password" data-target="exampleInputPassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                                        @error( 'password' )
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user" id="exampleInputPasswordConfirm" placeholder="New Password Confirmation">
                                        <i class="fa fa-eye position-absolute toggle-password" data-target="exampleInputPasswordConfirm" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                                        @error( 'password_confirmation' )
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Send
                                    </button>

                                </form>
                                <hr>
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

        document.querySelectorAll('.toggle-password').forEach(toggleIcon => {
            toggleIcon.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const isPassword = passwordInput.type === 'password';

                // Toggle password visibility
                passwordInput.type = isPassword ? 'text' : 'password';

                // Change the icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });

    </script>

@endpush


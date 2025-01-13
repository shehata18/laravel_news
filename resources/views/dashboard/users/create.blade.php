@extends('layouts.dashboard.app')@section( 'title','Create User')
@section('body')
    <br>
    <center>
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2 style="text-align: center">Create New User <i class="fas fa-user"></i></h2><br><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name of User">
                            @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Enter username">
                            @error('username')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Enter User Email">
                            @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Enter User phone">
                            @error('phone')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <select name="status" class="form-control" id="">
                                <option selected value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                            @error('status')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select name="email_verified_at" class="form-control" id="">
                                <option selected value="">Email Status</option>
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>

                            @error('email_verified_at')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="country" class="form-control" placeholder="Enter User Country Name">
                            @error('country')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="city" class="form-control" placeholder="Enter User City">
                            @error('city')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="street" class="form-control" placeholder="Enter User Street">
                            @error('street')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="file" name="image" class="form-control">
                            @error( 'image')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="password" name="password" id="exampleInputPassword" class="form-control" placeholder="Enter User Password">
                            <i class="fa fa-eye position-absolute toggle-password" data-target="exampleInputPassword" style="top: 50%; right: 20px; transform: translateY(-80%); cursor: pointer;"></i>
                            @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="exampleInputPasswordConfirm" class="form-control" placeholder="Enter Password Again">
                            <i class="fa fa-eye position-absolute toggle-password" data-target="exampleInputPasswordConfirm" style="top: 50%; right: 20px; transform: translateY(-80%); cursor: pointer;"></i>

                            @error('password_confirmation')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Create User</button>

            </div>
        </form>
    </center>

@endsection
@push( 'js')
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



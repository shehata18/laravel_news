@extends('layouts.frontend.app')
@section('title','Contact us')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{ route('frontend.contact.index') }}">Contact</a></li>

@endsection
@section( 'body' )

    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
{{--                        @if(session('success'))--}}
{{--                            <div class="alert alert-success">--}}
{{--                                {{ session('success') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        <form action="{{ route('frontend.contact.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name" />
                                    <strong class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                                <div class="form-group col-md-6">
                                    <input name="phone" type="text" class="form-control" placeholder="Your Phone" />
                                    <strong class="text-danger">
                                        @error('phone')
                                        {{ $message }}
                                        @enderror
                                    </strong>
                                </div>

                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" placeholder="Your Email" />
                                <strong class="text-danger">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </strong>
                            </div>

                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="Subject" />
                                <strong class="text-danger">
                                    @error('title')
                                    {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="5" placeholder="Message"></textarea>
                                <strong class="text-danger">
                                    @error('body')
                                    {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and working contact form with Ajax
                            & PHP in a few minutes. Just copy and paste the files, add a little code and you're done.
                            <a href="">Download Now</a>. </p>
                        <p><i class="fa fa-map-marker"></i>{{ $getSetting->street }}, {{$getSetting->city}}
                            , {{ $getSetting->country }}</p>
                        <p><i class="fa fa-envelope"></i>{{ $getSetting->email }}</p>
                        <p><i class="fa fa-phone"></i>{{ $getSetting->phone }}</p>
                        <div class="social">
                            <a href="{{ $getSetting->twitter }}" title="twitter"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $getSetting->facebook}}" title="facebook"><i class="fab fa-facebook-f"></i> </a>
                            <a href="{{ $getSetting->linkedin }}" title="linkedin"><i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="{{ $getSetting->instagram }}" title="instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $getSetting->youtube }}" title="youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection

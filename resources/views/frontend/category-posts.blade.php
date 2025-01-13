@extends('layouts.frontend.app')
@section('title',  $category->name)
@push( 'header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{ route('frontend.category.posts',$category->slug) }}">{{$category->name }}</a></li>

@endsection

@section('body')
    <br><br>

    <!-- Main News Start-->
    <div class="d-flex justify-content-center">
        <h1>{{ $category->name}}</h1>
    </div>
    <br><br>
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse( $category_posts as $category_post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img alt="img" src="{{ $category_post->images->first()->path }} "/>
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show',$category_post->slug) }}" title="{{$category_post->title}}">{{ $category_post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Category is Empty
                            </div>
                        @endforelse
                    </div>
                    {{ $category_posts->links() }}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Other Categories</h2>
                        <ul>
                            @foreach( $categories as $category)
                                <li>
                                    <a href=" {{ route('frontend.category.posts', $category->slug) }}">{{ $category->name  }}</a>
                                </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->


@endsection

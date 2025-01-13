@extends('layouts.frontend.app')
@section('title','Home')
@section( 'meta_desc' )
    {{ $getSetting->small_desc }}
@endsection
@push( 'header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    @parent
@endsection
@section('body')

@php
    $latest_three_posts = $latest_posts->take(3);
@endphp
    <!-- Top News Start-->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div class="row tn-slider">
                        @foreach( $latest_posts as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="{{ $post->images()->first()->path ?? '' }}" alt=""/>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                @php
                    $four_posts = $latest_posts->take(4);
                @endphp

                <div class="col-md-6 tn-right">
                    <div class="row">
                        @foreach( $four_posts as $post )
                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{ $post->images()->first()->path ?? '' }}" alt=""/>
                                <div class="tn-title">
                                    <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title  }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                @foreach( $categories_with_posts as $category)
                    <div class="col-md-6">
                        <h2>{{ $category->name }}</h2>
                        <div class="row cn-slider">
                            @foreach( $category->posts as $post )
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="{{ $post->images()->first()->path ?? '' }}" alt=""/>
                                    <div class="cn-title">
                                        <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Category News End-->


    <!-- Tab News Start-->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#oldest"
                            >Oldest News</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular"
                            >Popular News</a
                            >
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div id="oldest" class="container tab-pane active">
                            @foreach( $oldest_posts as $oldest)
                            <div class="tn-news">
                                <div class="tn-img">
                                    <img src="{{ $oldest->images->first()->path ?? '' }}" alt=""/>
                                </div>
                                <div class="tn-title">
                                    <a href="{{ route('frontend.post.show',$oldest->slug) }}">{{ $oldest->title }}</a>
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <div id="popular" class="container tab-pane fade">
                            @foreach( $most_posts_comments as $posts)

                            <div class="tn-news">
                                <div class="tn-img">
                                    <img src="{{ $posts->images()->first()->path ?? '' }}" alt=""/>
                                </div>
                                <div class="tn-title">
                                    <a href="{{ route('frontend.post.show',$posts->slug) }}">{{ $posts->title }}  {{ "Comments:  " . $posts->comments_count }} </a>
                                </div>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed"
                            >Latest News</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read"
                            >Most Read</a
                            >
                        </li>
                    </ul>

{{--                    @php--}}
{{--                        $latest_three_posts = $latest_posts->take(3);--}}
{{--                    @endphp--}}
                    <div class="tab-content">
                        {{-- Content Latest News --}}
                        <div id="m-viewed" class="container tab-pane active">
                            @foreach( $latest_three_posts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img style="width: 150px; height: 113px;" src="{{ asset($post->images()->first()->path ?? '')}}" alt=""/>
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div id="m-read" class="container tab-pane fade">
                            @foreach( $most_posts_views as $post)
                            <div class="tn-news">
                                <div class="tn-img">
                                    <img src="{{ $post->images->first()->path ?? ''}}" alt=""/>
                                </div>
                                <div class="tn-title">
                                    <a href="">{{ $post->title }} {{ $post->num_of_views }}</a>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News Start-->

    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">

                    @foreach( $latest_posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images()->first()->path ?? '' }}"  alt=""/>
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title}}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $latest_posts->links() }}

                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Read More</h2>
                        <ul>
                            @foreach( $read_more_posts as $post)
                                <li><a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->

@endsection

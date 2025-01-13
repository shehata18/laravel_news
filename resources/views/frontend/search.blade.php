@extends('layouts.frontend.app')
@section('title','Search')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Keyword: <strong class="text-info">{{ $keyword }}</strong></li>

@endsection
@section('body')
    <br><br><br>
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @if ($posts->isEmpty())
                            <div class="col-12">
                                <p class="text-center">No posts found for the keyword: <strong>{{ $keyword }}</strong>.</p>
                            </div>
                        @else
                            @foreach( $posts as $post)
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                            <img src="{{ $post->images()->first()->path }}"  alt=""/>
                                            <div class="mn-title">
                                                <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title}}</a>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        @endif

                    </div>
                </div>
                    {{ $posts->links() }}

            </div>
        </div>
    </div>
    <!-- Main News End-->










@endsection

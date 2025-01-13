@extends('layouts.frontend.app')
@section('title')
    Show | {{ $mainPost->title }}
@endsection
@section( 'meta_desc')
    {{ $mainPost->small_desc }}
@endsection
@push( 'header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">
        <a href="{{ route('frontend.post.show',$mainPost->slug) }}">{{ $mainPost->title }}</a></li>

@endsection
@section('body')

    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach( $mainPost->images as $image)
                                <div class="carousel-item @if ( $loop->index == 0 ) active @endif">
                                    <img style="width: 200px; height: 400px;" src="{{ asset( $image->path )}}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 style="color: #e5e7eb">{{ $mainPost->title}}</h5>
                                        {{--                                        <p>--}}
                                        {{--                                            {!!  substr($mainPost->description,0,100) !!}--}}
                                        {{--                                        </p>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span>
                        </a> <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user"></i>
                        <span>&nbsp;&nbsp;Publisher: {{ $mainPost->user->name }}</span>
                    </div>

                    <!-- Article Content -->
                    <div class="sn-content">
                        {!! $mainPost->description !!}
                    </div>

                    <!-- Comment Section -->
                    <div class="comment-section">
                        @if($mainPost->comment_able == 1)
                            @if(auth()->check())
                                <form id="commentForm">
                                    <div class="comment-input">
                                        @csrf
                                        <input name="comment" type="text" placeholder="Add a comment..." id="commentBox" />
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="post_id" value="{{ $mainPost->id }}">
                                        <button type="submit" id="addCommentBtn">Comment</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    Please <a href="{{ route('login') }}">log in</a> to comment.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                Unable to comment
                            </div>
                        @endif
                    </div>



                    <div style="display: none" id="errorMsg" class="alert alert-danger">
                        {{-- Display error --}}
                    </div>
                    <!-- Display Comments -->
                    <div class="comments">
                        @foreach( $mainPost->comments as $comment)
                            <div class="comment">
                                <img src="{{ asset($comment->user->image) }}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">{{ $comment->user->name }}</span>
                                    <p class="comment-text">{{ $comment->comment }}</p>
                                    <span class="comment-time text-muted" style="font-size: 0.9em;">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Show More Button -->
                    @if( $mainPost->comments->count()>2)
                        <button id="showMoreBtn" class="show-more-btn">Show more</button>
                    @endif

                    <!-- Related News (Placed within the main content) -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row">
                            @foreach( $posts_belongs_to_category as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{ $post->images->first()->path ?? '' }}" class="img-fluid" alt="{{ $post->title }}" />
                                        <div class="sn-title">
                                            <a style="color:blue;" title="{{ $post->title }}" href="{{ route('frontend.post.show',$post->slug)}}" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This: {{ $category->name }}</h2>
                            <div class="news-list">
                                @foreach( $posts_belongs_to_category as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img alt="pos-img" src="{{ asset($post->images->first()->path ?? '')}}" />
                                        </div>
                                        <div class="nl-title">
                                            <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#featured">Latest</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- Latest Posts-->
                                    <div id="featured" class="container tab-pane active">
                                        @foreach( $latest_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img style="width: 100px; height: 75px;" alt="{{ $post->title }}" src="{{asset($post->images()->first()->path ?? '') }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a title="{{ $post->title }}" href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Popular Posts -->
                                    <div id="popular" class="container tab-pane fade">
                                        @foreach( $greatest_posts_comments as $posts)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img alt="{{ $posts->title }}" src="{{ asset($posts->images->first()->path ?? '' )}}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('frontend.post.show',$posts->slug) }}">{{ $posts->title  }}
                                                        Comments: <b>{{ $posts->comments_count }}</b></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">News Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach( $categories as $category)
                                        <li>
                                            <a href="{{ route('frontend.category.posts', $category->slug) }}">{{ $category->name }}</a><span>({{ $category->posts_count }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <a href="">National</a> <a href="">International</a> <a href="">Economics</a>
                                <a href="">Politics</a> <a href="">Lifestyle</a> <a href="">Technology</a> <a href="">Trades</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Single News End-->

@endsection

@push('js')
    <script>
        var baseUrl = "{{ asset('') }}";
        // Show more comments
        $(document).on('click', '#showMoreBtn', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('frontend.post.getAllComments',$mainPost->slug) }}",
                type: "GET",
                success: function (data) {
                    $('.comments').empty();
                    $.each(data, function (key, comment) {
                        $('.comments').append(`
                                <div class="comment">
                                    <img src="${comment.user.image}" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">${comment.user.name}</span>
                                        <p class="comment-text">${comment.comment}</p>
                                        <span class="comment-time text-muted" style="font-size: 0.9em;">${moment(comment.created_at).fromNow()}</span>
                                    </div>
                                </div>`);

                        $('#showMoreBtn').hide();
                    });
                },
                error: function (data) {


                },
            });
        });

        // Save comments
        $(document).on('submit', '#commentForm', function (e) {
            e.preventDefault();
            let formData = new FormData($(this)[0]);
            $('#commentBox').val('');
            $.ajax({
                url: "{{ route('frontend.post.comments.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#errorMsg').hide();
                    $('.comments').prepend(`<div class="comment">
                                <img src="${baseUrl}${data.comment.user.image}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${data.comment.user.name}</span>
                                    <p class="comment-text">${data.comment.comment}</p>
                                    <span class="comment-time text-muted" style="font-size: 0.9em;">${moment(comment.created_at).fromNow()}</span>

                                </div>
                            </div>`);

                },
                error: function (data) {
                    let response = $.parseJSON(data.responseText);
                    $('#errorMsg').text(response.errors.comment).show();

                },
            });
        })
    </script>
@endpush

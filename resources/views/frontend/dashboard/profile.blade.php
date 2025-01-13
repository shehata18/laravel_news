@extends('layouts.frontend.app')
@section( 'title' )
    Profile
@endsection
@section('body')

    <!-- Profile Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar',['profile_active' => 'active'])
        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <img src="{{  asset(auth()->guard('web')->user()->image) }}" alt="User Image" class="profile-img rounded-circle" style="width: 100px; height: 100px;" />
                    <span class="username">{{auth()->guard('web')->user()->name}}</span>
                </div>
                <br>

                @if( session()->has('errors'))
                    <div class="alert alert-danger">
                        @foreach( session('errors')->all() as $error )
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <!-- Add Post Section -->
                <form action="{{ route('frontend.dashboard.post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <section id="add-post" class="add-post-section mb-5">
                        <h2>Add Post</h2>
                        <div class="post-form p-3 border rounded">
                            <!-- Post Title -->
                            <input type="text" name="title" id="postTitle" class="form-control mb-2" placeholder="Post Title" />

                            <!-- Small Description-->
                            <textarea name="small_desc" id="" class="form-control mb-2"  placeholder="Enter Small description"></textarea>

                            <!-- Post Content -->
                            <textarea name="description" id="postContent"  class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>


                            <!-- Image Upload -->
                            <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*" multiple />
                            <div class="tn-slider mb-2">
                                <div id="imagePreview" class="slick-slider"></div>
                            </div>

                            <!-- Category Dropdown -->
                            <select name="category_id" id="postCategory" class="form-control">
                                <option value="" selected>Select Category</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>

                                @endforeach
                            </select> <br>

                            <!-- Enable Comments Checkbox -->
                            <label class="label"> Enable Comments:
                                <input name="comment_able" type="checkbox" class="" /> </label><br>

                            <!-- Post Button -->
                            <button type="submit" class="btn btn-primary post-btn">Post</button>
                        </div>
                    </section>
                </form>


                <!-- Posts Section -->
                <section id="posts" class="posts-section">
                    <h2>Recent Posts</h2>
                    <div class="post-list">
                        <!-- Post Item -->

                        @forelse( $posts as $post )

                            <div class="post-item mb-4 p-3 border rounded">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <img src="{{  asset(auth()->guard('web')->user()->image) }}" alt="User Image" class="rounded-circle" style="width: 50px; height: 50px;" />
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                    </div>
                                </div>
                                <h4 class="post-title">{{ $post->title }}</h4>
                                <p class="post-content"> {!! chunk_split($post->description, 40)  !!}</p>

                                <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#newsCarousel" data-slide-to="1"></li>
                                        <li data-target="#newsCarousel" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach( $post->images as $image)
                                            <div class="carousel-item @if( $loop->index == 0 ) active @endif">
                                                <img src="{{ asset($image->path)}}" class="d-block w-100" alt="First Slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>{{ $post->title }}</h5>

                                                </div>
                                            </div>

                                        @endforeach

                                        <!-- Add more carousel-item blocks for additional slides -->
                                    </div>
                                    <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span> </a>
                                    <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span> </a>
                                </div>

                                <div class="post-actions d-flex justify-content-between">
                                    <div class="post-stats">
                                        <!-- View Count -->
                                        <span class="me-3">
                                  <i class="fas fa-eye"></i> {{ $post->num_of_views }}
                              </span>
                                    </div>

                                    <div>
                                        <a href="{{ route('frontend.dashboard.post.edit', $post->slug) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit </a>

                                        <a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deletePostModal_{{ $post->id }}">
                                            <i class="fas fa-trash"></i> Delete </a>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deletePostModal_{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deletePostModalLabel_{{ $post->id }}">
                                                            Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this post?
                                                    </div>
                                                    <form id="deleteForm_{{ $post->id }}" action="{{ route('frontend.dashboard.post.delete')}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="slug" value="{{ $post->slug }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <button id="commentBtn_{{ $post->id }}" class="getComments btn btn-sm btn-outline-secondary" post-id="{{ $post->id }}">
                                            <i class="fas fa-comment"></i> Comments
                                        </button>

                                        <button id="hideCommentId_{{ $post->id }}" class="hideComments btn btn-sm btn-outline-secondary" style="display: none" post-id="{{ $post->id }}">
                                            <i class="fas fa-comment"></i> Hide Comments
                                        </button>
                                    </div>
                                </div>

                                <!-- Display Comments -->
                                <div id="displayComments_{{ $post->id }}" class="comments" style="display: none">
                                    <!-- Add more comments here for demonstration -->
                                </div>
                            </div>

                        @empty
                            <div class="alert alert-info">
                                No posts !
                            </div>

                        @endforelse

                        <!-- Add more posts here dynamically -->
                    </div>
                </section>
            </section>
        </div>
    </div>
    <!-- Profile End -->

@endsection

@push( 'js' )
    <script>
        $(function () {
            $('#postImage').fileinput({
                theme: 'fa5',
                showUpload: false,
                showCancel: true,
                initialPreviewAsData: true,
            });

            $('#postContent').summernote({
                placeholder: 'Enter post body',
                height: 200,
            });
        });

        // Get Comments
        $(document).on('click', '.getComments', function (e) {
            e.preventDefault();
            var post_id = $(this).attr('post-id');
            $.ajax({
                type: 'GET',
                url: '{{ route('frontend.dashboard.post.getComments', ":post_id") }}'.replace(':post_id', post_id),
                success: function (response) {
                    $('#displayComments_'+post_id).empty();
                    console.log(response);
                    $.each(response.data, function (indexInArray, comment) {
                        $('#displayComments_'+post_id).append(`<div class="comment">
                                        <img src="${comment.user.image}" alt="User Image" class="comment-img" />
                                        <div class="comment-content">
                                            <span class="username">${comment.user.name}</span>
                                            <p class="comment-text">${comment.comment}</p>
                                        </div>
                                    </div>`).show();
                    });
                    $('#commentBtn_'+post_id).hide();
                    $('#hideCommentId_'+post_id).show()

                }

            });
        });
        // Hide Comments
        $(document).on('click','.hideComments', function (e){
            e.preventDefault();
            var post_id = $(this).attr('post-id');

            // 1- hide comments
            $('#displayComments_'+post_id).hide()

            // 2- Hide button ( Hide Comments )
            $('#hideCommentId_'+post_id).hide();

            // 3- Appear button ( Comments )
            $('#commentBtn_'+post_id).show();

        });



    </script>
@endpush

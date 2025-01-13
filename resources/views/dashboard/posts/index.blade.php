@extends('layouts.dashboard.app')
@section( 'title','Posts')
@section('body')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more
            information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Posts Management</h6>
                <a href="{{ url()->current() }}" class="text-primary"><i class="fas fa-sync-alt"></i></a>

            </div>


            <!-- Filter -->
            @include('dashboard.posts.filter.filter')

            <!-- Table of Posts -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created at</th>
                            <th rowspan="3">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse( $posts as $post)
                            <tr>
                                <td>{{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
                                <!-- Adjusted row number -->
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->user->name }}</td>
                                @if( $post->status == 1)
                                    <td style="color: forestgreen">Active</td>
                                @else
                                    <td style="color: darkred">Not Active</td>
                                @endif
                                <td>{{ $post->num_of_views }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                <td>
                                    <a style="color: red" href="javascript:void(0)" onclick="if(confirm('Do you want to delete the user')){ document.getElementById('delete_post_{{ $post->id }}').submit()} return false">
                                        <i title="delete" class="fas fa-trash"></i></a>
                                    &nbsp;&nbsp;&nbsp;<a href="{{ route('admin.posts.changeStatus', $post->id) }}"><i title="change-status" class="fas @if($post->status==1) fa-ban @else fa-play @endif "></i></a>
                                    &nbsp;&nbsp;&nbsp;<a style="color: green" href="{{ route('admin.posts.show', $post->id) }}"><i title="see" class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            <form id="delete_post_{{ $post->id }}" action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        @empty
                            <tr>
                                <td class="alert alert-info" colspan="6"> No Users</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $posts->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@extends('layouts.dashboard.app')@section( 'title','Categories')
@section('body')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Categories</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more
            information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Categories Table</h6>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">
                    <i class="fas fa-plus"></i>  Add Category
                </button>
                <a href="{{ url()->current() }}" class="btn btn-sm btn-secondary"> <i class="fas fa-sync-alt"></i>
                    Refresh </a>
            </div>


            <!-- Filter -->
            @include('dashboard.users.filter.filter',['context'=>'categories'])

            <!-- Table of Categories -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Posts Count</th>
                            <th>Created at</th>
                            <th rowspan="3">Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Posts Count</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse( $categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- Adjusted row number -->
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <span class="badge badge-{{ $category->status == 1 ? 'success' : 'danger' }}">
                                        {{ $category->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $category->posts_count}}</td>
                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="if(confirm('Do you want to delete this category')){ document.getElementById('delete_category_{{ $category->id }}').submit()} return false">
                                        <i title="delete" class="fas fa-trash"></i></a> &nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('admin.categories.changeStatus', $category->id) }}" class="btn btn-sm" style="background-color: {{ $category->status == 1 ? 'yellow' : 'lightgreen'  }}; color: white" title="{{ $category->status == 1 ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas {{ $category->status == 1 ? 'fa-ban' : 'fa-check' }}"></i> </a>
                                    <a href="javascript:void(0)" class="btn btn-sm" data-toggle="modal" data-target="#editCategory_{{ $category->id }}">
                                        <i class="fas fa-edit"></i> </a>
                                </td>
                            </tr>
                            <form id="delete_category_{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            </form>

                            {{-- Edit Category modal --}}
                            @include('dashboard.categories.edit')

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No categories found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $categories->links() }}
                </div>
            </div>

        </div>

        {{-- Modal Add New Category--}}
        @include('dashboard.categories.create')


    </div>
    <!-- /.container-fluid -->

@endsection

@push('styles')

    <style>
        .badge {
            font-size: 0.875rem;
        }

        .btn-group {
            gap: 0.25rem;
        }

        .table td {
            vertical-align: middle;
        }
    </style>

@endpush

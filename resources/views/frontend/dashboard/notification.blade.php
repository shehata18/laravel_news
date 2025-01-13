@extends('layouts.frontend.app')
@section( 'title' )
    Profile
@endsection
@section('body')

    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar', ['notify_active' => 'active'])

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('frontend.dashboard.notifications.deleteAll') }}" style="margin-left: 270px;" class="btn btn-sm btn-danger">Delete all</a>
                    </div>
                </div>
                <!-- "Mark All as Read" Button -->
                <form action="{{ route('frontend.dashboard.notifications.markAllRead') }}" method="POST" class="mb-3 text-right">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Mark All as Read</button>
                </form>

                @forelse($notifications as $notify)
                    <a href="{{ route('frontend.dashboard.notifications.markAsRead', ['id' => $notify->id, 'redirect' => $notify->data['link']]) }}">
                        <div class="notification alert {{ $notify->read_at ? 'alert-secondary' : 'alert-info' }}">
                            <strong> You have a notification from {{ $notify->data['user_name'] }}
                            </strong> Post title: {{ $notify->data['post_title'] }} . <br>
                            {{ $notify->created_at->diffForHumans() }}
                            <div class="float-right">
                                <button onclick="if(confirm('Are u sure to Delete this notification?')){ document.getElementById('deleteNotify').submit()} return false" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </a>
                    <form id="deleteNotify" action="{{ route('frontend.dashboard.notifications.delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="notify_id" value="{{ $notify->id }}">
                    </form>
                @empty
                    <div class="alert alert-info">
                        No notifications found
                    </div>
                @endforelse

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>


            </div>
        </div>
    </div>
    <!-- Dashboard End-->

@endsection


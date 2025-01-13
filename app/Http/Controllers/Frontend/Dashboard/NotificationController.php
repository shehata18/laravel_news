<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(6); // Adjust the number of items per page
        return view('frontend.dashboard.notification',compact('notifications'));
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead($id, Request $request)
    {
        // Find the notification by ID
        $notification = DatabaseNotification::findOrFail($id);

        // Check if the notification belongs to the authenticated user
        if ($notification->notifiable_id === auth()->id()) {
            $notification->markAsRead(); // Mark as read
        }

        // Redirect to the specified link or fallback to the dashboard
        return redirect($request->get('redirect', route('frontend.dashboard.notification')));
    }

    public function delete(Request $request)
    {
        $notification = auth()->user()->notifications->where('id', $request->notify_id)->first;
        if (!$notification) {
            return redirect()->back()->with('error', 'Notification not found');
        }
        $notification->delete();
        return redirect()->back()->with('success', 'Notification deleted.');

    }

    public function deleteAll(Request $request)
    {
        auth()->user()->notifications()->delete();
        Session::flash('success', 'All Notification deleted.');
        return redirect()->route('frontend.dashboard.notification');


    }

}

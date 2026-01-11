<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GeneralNotification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Delete all notifications.
     */
    public function destroyAll()
    {
        auth()->user()->notifications()->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'All notifications deleted successfully.');
    }

    /**
     * Get unread notifications count (for AJAX).
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications->count()
        ]);
    }

    /**
     * Get recent notifications (for dropdown).
     */
    public function recent()
    {
        $notifications = auth()->user()
            ->notifications()
            ->take(5)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Send a test notification.
     */
    public function sendTest()
    {
        auth()->user()->notify(new GeneralNotification(
            'Test Notification',
            'This is a test notification to verify the notification system is working correctly.',
            route('notifications.index'),
            'View Notifications',
            'info'
        ));

        return redirect()->route('notifications.index')
            ->with('success', 'Test notification sent successfully.');
    }

    /**
     * Show create notification form (admin only).
     */
    public function create()
    {
        $users = User::select('id', 'name', 'email')->get();
        return view('notifications.create', compact('users'));
    }

    /**
     * Send notification to users (admin only).
     */
    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string',
        ]);

        $users = User::whereIn('id', $request->users)->get();

        foreach ($users as $user) {
            $user->notify(new GeneralNotification(
                $request->title,
                $request->message,
                $request->action_url,
                $request->action_text ?? 'View',
                $request->type
            ));
        }

        return redirect()->route('notifications.create')
            ->with('success', 'Notification sent to ' . count($users) . ' user(s).');
    }
}

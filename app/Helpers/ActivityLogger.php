<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    /**
     * Log user login
     */
    public static function login($user)
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'subject' => 'User Login',
            'description' => $user->name . ' logged into the system',
            'event' => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log user logout
     */
    public static function logout($user)
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'subject' => 'User Logout',
            'description' => $user->name . ' logged out from the system',
            'event' => 'logout',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log profile update
     */
    public static function profileUpdated($user)
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'subject' => 'Profile Updated',
            'description' => $user->name . ' updated their profile',
            'event' => 'updated',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log password change
     */
    public static function passwordChanged($user)
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'subject' => 'Password Changed',
            'description' => $user->name . ' changed their password',
            'event' => 'updated',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\OtpPasswordResetNotification;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Handle the password reset link request.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email address input
        $this->validateEmail($request);

        // If OTP is enabled, handle OTP logic
        if (env('PASSWORD_RESET_METHOD') === 'otp') {
            return $this->sendOtp($request->email);
        }

        // Fallback to the default password reset link via email
        return parent::sendResetLinkEmail($request);
    }

    /**
     * Handle sending OTP for password reset.
     */
    protected function sendOtp($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        // Generate an OTP
        $otp = rand(100000, 999999);

        // Send OTP via email using the notification
        Notification::route('mail', $email)->notify(new OtpPasswordResetNotification($otp));

        // Optionally store the OTP in the session for validation later
        session(['otp' => $otp, 'email' => $email]);

        return back()->with('status', 'OTP has been sent to your email address.');
    }
}

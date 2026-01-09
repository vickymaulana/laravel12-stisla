<?php

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // If OTP method is enabled
        if (env('PASSWORD_RESET_METHOD') === 'otp') {
            $otp = session('otp');

            if ($request->otp !== $otp) {
                return back()->withErrors(['otp' => 'The OTP provided is incorrect.']);
            }
        }

        // Proceed with resetting the password if everything is valid
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->route('login')->with('status', 'Password reset successful.');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;

class OtpVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = Otp::where('user_id', Auth::id())
                  ->where('code', $request->otp)
                  ->where('expires_at', '>', now())
                  ->first();

        if ($otp) {
            $otp->update(['verified' => true]);
            return back()->with('message', 'OTP Verified!');
        }

        return back()->with('error', 'Invalid OTP');
    }
}

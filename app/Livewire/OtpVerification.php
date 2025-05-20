<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;

class OtpVerification extends Component
{
    public $otp;

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = Otp::where('user_id', Auth::id())
                  ->where('code', $this->otp)
                  ->where('expires_at', '>', now())
                  ->first();

        if ($otp) {
            $otp->update(['verified' => true]);
            session()->flash('message', 'OTP Verified!');
        } else {
            session()->flash('error', 'Invalid or expired OTP.');
        }
    }

    public function render()
    {
        return view('livewire.otp-verification');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class OtpInput extends Component
{
    public array $otp = ['', '', '', '', '', ''];
    public string $error = '';
    public bool $loading = false;

    public function updatedOtp($value, $key)
    {
        // Only allow numeric input
        if (!is_numeric($value)) {
            $this->otp[$key] = '';
            return;
        }

        // Auto-submit when all 6 digits filled
        if (collect($this->otp)->every(fn($d) => is_numeric($d) && $d !== '')) {
            $this->verify();
        }
    }

    public function verify()
    {
        $code = implode('', $this->otp);
        $user = Auth::user();

        if (!RateLimiter::attempt('otp-'.$user->id, 5)) {
            $this->error = 'Too many attempts. Please wait.';
            return;
        }

        $otp = Otp::where('user_id', $user->id)
            ->where('code', $code)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $otp) {
            $this->error = 'Invalid or expired OTP.';
            return;
        }

        $otp->update(['verified_at' => now()]);
        $this->error = '';
        session()->flash('success', 'OTP verified!');
    }

    public function render()
    {
        return view('livewire.otp-input');
    }
}

?>
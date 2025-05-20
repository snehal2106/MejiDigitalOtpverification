<form wire:submit.prevent="verifyOtp">
    <input type="text" wire:model="otp" placeholder="Enter OTP" />
    <button type="submit">Verify</button>

    @if (session()->has('message'))
        <div style="color: green">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div style="color: red">{{ session('error') }}</div>
    @endif
</form>

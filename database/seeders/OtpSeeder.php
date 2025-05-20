<?php

namespace Database\Seeders;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure you have a user to associate the OTP with
        $user = User::first(); // Get the first user from the database, or you can create one

        if ($user) {
            // Create an OTP entry for the user
            Otp::create([
                'user_id' => $user->id,   // Link to the user
                'code' => '123456',        // OTP code (you can generate random OTPs if needed)
                'type' => 'email',         // You can set this to email, phone, etc.
                'expires_at' => Carbon::now()->addMinutes(10),  // Set expiration to 10 minutes from now
            ]);
        }
    }
}

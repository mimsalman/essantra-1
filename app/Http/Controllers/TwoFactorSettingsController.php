<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorSettingsController extends Controller
{
    public function enable(Request $request)
    {
        $user = $request->user();

        $user->two_factor_enabled = true;

        // clear any old otp
        $user->two_factor_otp_hash = null;
        $user->two_factor_otp_expires_at = null;

        $user->save();

        // ✅ very important: user must verify again
        $request->session()->forget('2fa_passed');

        // ✅ send them to OTP page
        return redirect()->route('2fa.challenge')
            ->with('success', '2-step verification enabled. Please verify to continue.');
    }

    public function disable(Request $request)
    {
        $user = $request->user();

        $user->two_factor_enabled = false;

        // clear any pending OTP
        $user->two_factor_otp_hash = null;
        $user->two_factor_otp_expires_at = null;

        $user->save();

        // clear session flag
        $request->session()->forget('2fa_passed');

        return back()->with('success', '2-step verification disabled.');
    }
}
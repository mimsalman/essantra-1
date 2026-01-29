<?php

namespace App\Http\Controllers;

use App\Notifications\TwoFactorOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TwoFactorChallengeController extends Controller
{
    public function show(Request $request)
    {
        // already passed
        if ((bool) $request->session()->get('2fa_passed', false)) {
            return $this->redirectAfterVerify($request);
        }

        $user = $request->user();

        // if 2fa not enabled, no need challenge
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('dashboard');
        }

        return view('auth.twofactor-email');
    }

    public function send(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('dashboard');
        }

        // 6 digit OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->two_factor_otp_hash = Hash::make($otp);
        $user->two_factor_otp_expires_at = now()->addMinutes(10);
        $user->save();

        $user->notify(new TwoFactorOtp($otp, 10));

        return back()->with('success', 'Verification code sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('dashboard');
        }

        if (!$user->two_factor_otp_hash || !$user->two_factor_otp_expires_at) {
            return back()->withErrors(['otp' => 'Please request a new code.']);
        }

        if (now()->greaterThan($user->two_factor_otp_expires_at)) {
            return back()->withErrors(['otp' => 'Code expired. Please request a new one.']);
        }

        if (!Hash::check($request->otp, $user->two_factor_otp_hash)) {
            return back()->withErrors(['otp' => 'Invalid code.']);
        }

        // ✅ success
        $request->session()->put('2fa_passed', true);

        // clear OTP so it can't be reused
        $user->two_factor_otp_hash = null;
        $user->two_factor_otp_expires_at = null;
        $user->save();

        return $this->redirectAfterVerify($request);
    }

    private function redirectAfterVerify(Request $request)
    {
        $user = $request->user();

        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
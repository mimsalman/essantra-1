<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function enable2fa(Request $request)
    {
        $user = $request->user();

        $user->two_factor_enabled = true;
        $user->two_factor_otp_hash = null;
        $user->two_factor_otp_expires_at = null;
        $user->save();

        $request->session()->forget('2fa_passed');

        return redirect()->route('2fa.challenge')
            ->with('success', '2-step verification enabled. Please verify to continue.');
    }

    public function disable2fa(Request $request)
    {
        $user = $request->user();

        $user->two_factor_enabled = false;
        $user->two_factor_otp_hash = null;
        $user->two_factor_otp_expires_at = null;
        $user->save();

        $request->session()->forget('2fa_passed');

        return back()->with('success', '2-step verification disabled.');
    }
}
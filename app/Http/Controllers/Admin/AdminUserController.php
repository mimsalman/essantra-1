<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', 1)->latest()->get();
        $customers = User::where('is_admin', 0)->latest()->get();

        return view('admin.users.index', compact('admins', 'customers'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:190','unique:users,email'],
            'password' => ['required','string','min:6'],
            'is_admin' => ['nullable'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => (bool)($data['is_admin'] ?? false),
        ]);

        return back()->with('success', 'User added successfully!');
    }

    public function destroy(User $user)
    {
        // prevent deleting self (optional)
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}

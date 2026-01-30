<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('admin.profile', [
            'user' => $request->user(),
        ]);
    }
}
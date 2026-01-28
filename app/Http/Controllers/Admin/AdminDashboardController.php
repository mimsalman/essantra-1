<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $revenue = Order::whereIn('status', ['paid', 'completed'])->sum('total');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        $lowStock = Perfume::where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalOrders', 'pendingOrders', 'revenue', 'recentOrders', 'lowStock'
        ));
    }
}

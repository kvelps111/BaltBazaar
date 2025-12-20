<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Report;
use App\Models\BannedUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'total_listings' => Listing::count(),
            'active_listings' => Listing::where('created_at', '>=', now()->subDays(30))->count(),
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'banned_users' => BannedUser::count(),
        ];

        $recentReports = Report::with(['listing', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentListings = Listing::with(['user', 'school', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentListings'));
    }
}

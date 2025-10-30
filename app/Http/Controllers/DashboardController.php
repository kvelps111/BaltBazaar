<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class DashboardController extends Controller
{
    

public function index()
{
    $latestListings = Listing::with(['photos', 'school', 'category'])
        ->latest()
        ->take(3)
        ->get();

    return view('dashboard', compact('latestListings'));
}


}

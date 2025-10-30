<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Http\Requests\StoreListingRequest;


class ListingController extends Controller
{
    
    public function index()
    {
        $filters = [
            'region' => request('region'),
            'school' => request('school'),
            'category' => request('category')
        ];

        return view('listings.index', [
            'listings' => Listing::with('school', 'photos')
                ->latest()
                ->filter($filters)
                ->paginate(10),
            'regions' => School::distinct()->pluck('region'),
            'schools' => School::all(),
            'categories' => Category::all()
        ]);
    }
}

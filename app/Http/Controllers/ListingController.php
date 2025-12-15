<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Http\Requests\StoreListingRequest;


class ListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index()
{
    $filters = [
        'region' => request('region'),
        'school' => request('school'),
        'category' => request('category')
    ];
    
    $query = Listing::with('school', 'photos')
        ->filter($filters);
    
    //  price sorting
    if (request('sort_price')) {
        $query->orderBy('price', request('sort_price'));
    } else {
        $query->latest();
    }
    
    return view('listings.index', [
        'listings' => $query->paginate(12),
        'regions' => School::distinct()->pluck('region'),
        'schools' => School::all(),
        'categories' => Category::all()
    ]);
}

    
    public function create()
    {
        return view('listings.create', [
            'schools' => School::orderBy('region')->orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get()
        ]);
    }


    public function store(StoreListingRequest $request)
    {
        $validated = $request->validated();

        
        $listing = Listing::create(array_merge($validated, [
            'user_id' => auth()->id()
        ]));

        
        if ($request->hasFile('photos')) { 
            foreach ($request->file('photos') as $photo) {
                $listing->photos()->create([
                    'photo' => $photo->store('photos', 'public')
                ]);
            }
        }

        return redirect()->route('listings.index')
            ->with('success', 'Sludinājums veiksmīgi izveidots!');
    }

    public function show(Listing $listing)
    {

        $listing->load('photos', 'school', 'user');

        return view('listings.show', compact('listing'));
    }

    public function myListings()
    {
        return view('listings.user.index', [
            'listings' => auth()->user()->listings()
                ->with('school', 'photos')
                ->get()
        ]);
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return back()->with('success', 'Sludinājums dzēsts!');
    }
}

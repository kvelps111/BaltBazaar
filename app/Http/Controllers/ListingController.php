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
        
        $listing->load('photos', 'school');

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

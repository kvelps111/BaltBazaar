<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Storage;

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

        // price sorting
        $sortPrice = in_array(request('sort_price'), ['asc', 'desc']) ? request('sort_price') : null;
        if ($sortPrice) {
            $query->orderBy('price', $sortPrice);
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
                ->paginate(12)
        ]);
    }

    public function edit(Listing $listing)
    {
        $listing->load('photos');

        return view('listings.edit', [
            'listing'    => $listing,
            'schools'    => School::orderBy('region')->orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {

        $listing->update($request->only(['title', 'description', 'price', 'school_id', 'category_id']));

        // Remove photos the user marked for deletion
        if ($request->filled('remove_photos')) {
            $toRemove = ListingPhoto::whereIn('id', $request->remove_photos)
                ->where('listing_id', $listing->id)
                ->get();

            foreach ($toRemove as $photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }
        }

        // Add new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $listing->photos()->create([
                    'photo' => $photo->store('photos', 'public'),
                ]);
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Sludinājums veiksmīgi atjaunināts!');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return back()->with('success', 'Sludinājums dzēsts!');
    }
}

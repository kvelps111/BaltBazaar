<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Http\Requests\StoreListingRequest;
use Illuminate\Support\Facades\RateLimiter;

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
        $user = auth()->user();
        $rateKey = 'create-listing:' . $user->id;

        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return redirect()->back()
                ->withInput()
                ->withErrors(['limit' => "Pārāk daudz sludinājumu. Mēģiniet vēlreiz pēc {$seconds} sekundēm."]);
        }

        if ($user->listings()->whereNull('deleted_at')->count() >= 20) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['limit' => 'Jums jau ir 20 aktīvi sludinājumi. Dzēsiet kādu pirms jauna pievienošanas.']);
        }

        RateLimiter::hit($rateKey, 86400);

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

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return back()->with('success', 'Sludinājums dzēsts!');
    }
}

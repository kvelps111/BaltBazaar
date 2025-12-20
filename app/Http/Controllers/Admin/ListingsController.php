<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function index()
    {
        $filters = [
            'region' => request('region'),
            'school' => request('school'),
            'category' => request('category')
        ];

        $query = Listing::with(['user', 'school', 'category', 'photos'])
            ->filter($filters);

        // Price sorting
        if (request('sort_price')) {
            $query->orderBy('price', request('sort_price'));
        } else {
            $query->latest();
        }

        return view('admin.listings.index', [
            'listings' => $query->paginate(15)->appends(request()->query()),
            'regions' => School::distinct()->pluck('region'),
            'schools' => School::all(),
            'categories' => Category::all()
        ]);
    }

    public function deleted()
    {
        $listings = Listing::onlyTrashed()
            ->with(['user', 'school', 'category', 'photos'])
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.listings.deleted', compact('listings'));
    }

    public function showDeleted($id)
    {
        $listing = Listing::onlyTrashed()
            ->with(['user', 'school', 'category', 'photos'])
            ->findOrFail($id);

        return view('admin.listings.show-deleted', compact('listing'));
    }

    public function destroy(Listing $listing)
    {
        // Delete associated photos
        $listing->photos()->delete();

        // Delete the listing
        $listing->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Listing deleted successfully.');
    }
}

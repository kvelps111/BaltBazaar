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
        $sortPrice = in_array(request('sort_price'), ['asc', 'desc']) ? request('sort_price') : null;
        if ($sortPrice) {
            $query->orderBy('price', $sortPrice);
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
        $listing->delete();

        return redirect()->route('admin.listings.index')->with('success', 'Listing deleted successfully.');
    }
}

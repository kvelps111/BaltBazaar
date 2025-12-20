<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Listings Management</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">Listings Management</h1>
                <p class="admin-subtitle">Pārvaldiet visus sludinājumus</p>
            </div>

            <!-- Navigation -->
            <nav class="admin-nav">
                <ul class="admin-nav-list">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item-inactive">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="admin-nav-item-inactive">
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="admin-nav-item-inactive">
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.listings.index') }}" class="admin-nav-item-active">
                            Listings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.listings.deleted') }}" class="admin-nav-item-inactive">
                            Deleted Listings
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Region Filter -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                        <select id="region" name="region" class="admin-form-select">
                            <option value="">All Regions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- School Filter -->
                    <div>
                        <label for="school" class="block text-sm font-medium text-gray-700 mb-1">School</label>
                        <select id="school" name="school" class="admin-form-select">
                            <option value="">All Schools</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ request('school') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category" class="admin-form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Sort -->
                    <div>
                        <label for="sort_price" class="block text-sm font-medium text-gray-700 mb-1">Sort by Price</label>
                        <select id="sort_price" name="sort_price" class="admin-form-select">
                            <option value="">Default</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="admin-btn-primary flex-1">
                            Filter
                        </button>
                        @if(request()->hasAny(['region', 'school', 'category', 'sort_price']))
                            <a href="{{ route('admin.listings.index') }}" class="admin-btn-secondary">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Listings Grid -->
            @if($listings->count())
                <div class="admin-listing-grid">
                    @foreach($listings as $listing)
                        <div class="admin-listing-card">
                            <!-- Listing Image -->
                            @php $firstPhoto = $listing->photos->first(); @endphp
                            @if($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}"
                                     alt="{{ $listing->title }}"
                                     class="admin-listing-image">
                            @else
                                <div class="admin-listing-image bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">📦</span>
                                </div>
                            @endif

                            <!-- Listing Content -->
                            <div class="admin-listing-content">
                                <h3 class="admin-listing-title">
                                    {{ $listing->title }}
                                </h3>

                                <p class="admin-listing-meta">
                                    By <a href="{{ route('admin.users.show', $listing->user) }}"
                                          class="text-green-600 hover:underline font-medium">
                                        {{ $listing->user->name }}
                                    </a>
                                </p>

                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                    {{ $listing->description }}
                                </p>

                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="admin-badge-active">
                                        {{ number_format($listing->price, 2) }} €
                                    </span>
                                    <span class="admin-badge-dismissed">
                                        {{ $listing->school->name }}
                                    </span>
                                    <span class="admin-badge-dismissed">
                                        {{ $listing->category->name }}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-500">
                                    Created {{ $listing->created_at->format('d.m.Y') }}
                                </p>

                                <!-- Actions -->
                                <div class="admin-listing-actions">
                                    <a href="{{ route('listings.show', $listing) }}"
                                       target="_blank"
                                       class="admin-btn-sm-primary flex-1 text-center">
                                        View
                                    </a>
                                    <form action="{{ route('admin.listings.destroy', $listing) }}"
                                          method="POST"
                                          class="flex-1"
                                          onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn-sm-danger w-full">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="admin-pagination">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="admin-section">
                    <div class="admin-empty-state">
                        <div class="admin-empty-icon">📦</div>
                        <h3 class="admin-empty-title">No listings found</h3>
                        <p class="admin-empty-description">There are no listings in the system</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

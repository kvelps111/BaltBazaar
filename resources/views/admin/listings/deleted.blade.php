<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Deleted Listings</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">User-Deleted Listings</h1>
                <p class="admin-subtitle">View listings that users have deleted</p>
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
                        <a href="{{ route('admin.listings.index') }}" class="admin-nav-item-inactive">
                            Listings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.listings.deleted') }}" class="admin-nav-item-active">
                            Deleted Listings
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.listings.index') }}"
                   class="admin-btn-secondary">
                    ← Back to Active Listings
                </a>
            </div>

            <!-- Deleted Listings Grid -->
            @if($listings->count())
                <div class="admin-listing-grid">
                    @foreach($listings as $listing)
                        <div class="admin-listing-card opacity-75 border-2 border-red-200">
                            <!-- Deleted Badge -->
                            <div class="absolute top-2 right-2 z-10">
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow">
                                    DELETED
                                </span>
                            </div>

                            <!-- Listing Image -->
                            @php $firstPhoto = $listing->photos->first(); @endphp
                            @if($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}"
                                     alt="{{ $listing->title }}"
                                     class="admin-listing-image grayscale">
                            @else
                                <div class="admin-listing-image bg-gray-200 flex items-center justify-center grayscale">
                                    <span class="text-gray-400 text-4xl">📦</span>
                                </div>
                            @endif

                            <!-- Listing Content -->
                            <div class="admin-listing-content">
                                <h3 class="admin-listing-title text-gray-700">
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

                                <p class="text-xs text-red-600 font-semibold mt-1">
                                    Deleted {{ $listing->deleted_at->format('d.m.Y H:i') }}
                                </p>

                                <!-- Actions -->
                                <div class="admin-listing-actions mt-4">
                                    <a href="{{ route('admin.listings.deleted.show', $listing->id) }}"
                                       class="admin-btn-sm-primary w-full text-center">
                                        View All Photos
                                    </a>
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
                        <div class="admin-empty-icon">✅</div>
                        <h3 class="admin-empty-title">No deleted listings found</h3>
                        <p class="admin-empty-description">There are no deleted listings in the system</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

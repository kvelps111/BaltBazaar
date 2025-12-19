<x-app-layout>
    <x-slot name="header"></x-slot>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50/30 relative z-10 py-12 px-6 max-w-7xl mx-auto">
        <!-- Latest Listings Section -->
        <div class="dashboard-section">
            <h2 class="dashboard-section-title">Jaunākie sludinājumi</h2>

            @if($latestListings->count())
                <div class="dashboard-grid">
                    @foreach($latestListings as $listing)
                        <a href="{{ route('listings.show', $listing) }}" class="listing-card">
                            <!-- Image -->
                            @php $firstPhoto = $listing->photos->first(); @endphp
                            <div class="listing-image">
                                @if ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->photo) }}"
                                         alt="{{ $listing->title }}">
                                @else
                                    <div class="listing-no-photo">No Photo</div>
                                @endif

                                <!-- Price Badge -->
                                <div class="price-badge">
                                    {{ number_format($listing->price, 2) }} €
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="listing-content">
                                <h3 class="listing-title" title="{{ $listing->title }}">
                                    {{ $listing->title }}
                                </h3>
                                <p class="listing-description" title="{{ $listing->description }}">
                                    {{ $listing->description }}
                                </p>
                                <div class="listing-meta">
                                    <span class="meta-badge">{{ $listing->school->name }}</span>
                                    <span class="meta-badge">{{ $listing->category->name }}</span>
                                </div>
                                <p class="listing-time">{{ $listing->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h2 class="empty-state-title">No listings yet</h2>
                    <p class="empty-state-description">Be the first to create one!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

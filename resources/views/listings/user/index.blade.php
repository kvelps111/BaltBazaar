<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">
            {{ __('Mani sludinājumi') }}
        </h2>
    </x-slot>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50/30 relative z-10 py-12 px-6">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Mani sludinājumi</h1>
            <p class="page-subtitle">Pārvaldiet savus sludinājumus un reklāmas</p>
        </div>

        @if($listings->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h2 class="empty-state-title">Jums vēl nav sludinājumu</h2>
                <p class="empty-state-description">Sāciet pārdot vai noma vienumus, izveidojot savu pirmo sludinājumu.</p>
                <a href="{{ route('listings.create') }}" class="btn-create">
                    + Izveidot pirmo sludinājumu
                </a>
            </div>
        @else
            <!-- Listings Grid -->
            <div class="user-listings-container">
                @foreach($listings as $listing)
                    <div class="user-listing-card">
                        <!-- Image -->
                        <div class="user-listing-image">
                            @php $firstPhoto = $listing->photos->first(); @endphp
                            @if ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}"
                                     alt="{{ $listing->title }}">
                            @else
                                <div class="user-listing-no-image">📸</div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="user-listing-content">
                            <div class="user-listing-header">
                                <h3 class="user-listing-title">{{ $listing->title }}</h3>
                                <p class="user-listing-school">{{ $listing->school->name }}</p>
                                <p class="user-listing-description">{{ $listing->description }}</p>
                            </div>

                            <!-- Meta Info -->
                            <div class="user-listing-meta">
                                <span>📁 {{ $listing->category->name }}</span>
                                <span>⏰ {{ $listing->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Price -->
                            <div class="user-listing-price">
                                {{ number_format($listing->price, 2) }} €
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="user-listing-actions">
                            <a href="{{ route('listings.show', $listing) }}" class="btn-view">
                                👁 Skatīt
                            </a>

                            <form action="{{ route('listings.destroy', $listing) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Vai tiešām vēlaties dzēst šo sludinājumu?')">
                                    🗑 Dzēst
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

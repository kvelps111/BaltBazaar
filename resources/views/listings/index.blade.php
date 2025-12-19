<x-app-layout>
    <x-slot name="header"></x-slot>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50/30">

        {{-- Page Header --}}
        <div class="page-header">
            <h1 class="page-title">Visi Sludinājumi</h1>
            <p class="page-subtitle">Atklāj labākos piedāvājumus no studentiem</p>
        </div>

        {{-- Top Filter Bar --}}
        <div class="filter-container">
            <div class="filter-wrapper">
                <form method="GET" class="filter-form">

                    {{-- Region --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="filter-icon"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                  clip-rule="evenodd" />
                        </svg>
                        <select id="region" name="region" class="filter-select">
                            <option value="">Reģions (visi)</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- School --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="filter-icon"
                             viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                            <path d="M6 12v5c3 3 9 3 12 0v-5" />
                        </svg>
                        <select id="school" name="school" class="filter-select">
                            <option value="">Skola (visas)</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ request('school') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="filter-icon"
                             fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <select id="category" name="category" class="filter-select">
                            <option value="">Kategorija (visas)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Sort --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="filter-icon"
                             fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <select id="sort_price" name="sort_price" class="filter-select">
                            <option value="">Cena (kārtot)</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Cena: No zemākās
                            </option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Cena: No augstākās
                            </option>
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <button type="submit" class="filter-btn">
                        <span>Filtrēt</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Listings --}}
        <div class="listings-container">
            <div class="listings-grid">
                @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing) }}" class="listing-card">

                        {{-- Image --}}
                        @php $firstPhoto = $listing->photos->first(); @endphp
                        <div class="listing-image">
                            @if ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}"
                                     alt="{{ $listing->title }}">
                            @else
                                <div class="listing-no-photo">
                                     No Photo
                                </div>
                            @endif

                            {{-- Price badge overlay --}}
                            <div class="price-badge">
                                {{ number_format($listing->price, 2) }} €
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="listing-content">
                            <h3 class="listing-title" title="{{ $listing->title }}">
                                {{ $listing->title }}
                            </h3>

                            <p class="listing-description" title="{{ $listing->description }}">
                                {{ $listing->description }}
                            </p>

                            {{-- Metadata badges --}}
                            <div class="listing-meta">
                                <span class="meta-badge">{{ $listing->school->name }}</span>
                                <span class="meta-badge">{{ $listing->category->name }}</span>
                            </div>

                            <p class="listing-time">⏰ {{ $listing->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $listings->links('components.pagination') }}
            </div>
        </div>
    </div>
</x-app-layout>

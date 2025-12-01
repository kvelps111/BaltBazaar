<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        /* Animated Background Elements */
        .bg-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: #2ecc71;
            opacity: 0.06;
            animation: float 25s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 300px;
            height: 300px;
            top: 50%;
            right: -150px;
            animation-delay: 3s;
            animation-duration: 20s;
        }

        .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: 30%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .circle:nth-child(4) {
            width: 350px;
            height: 350px;
            top: 20%;
            right: 15%;
            animation-delay: 9s;
            animation-duration: 22s;
        }

        .circle:nth-child(5) {
            width: 250px;
            height: 250px;
            bottom: 20%;
            left: 10%;
            animation-delay: 12s;
            animation-duration: 28s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.06;
            }
            33% {
                transform: translate(40px, -40px) scale(1.2);
                opacity: 0.1;
            }
            66% {
                transform: translate(-30px, 30px) scale(0.9);
                opacity: 0.04;
            }
        }

        /* Filter Section Styles */
        .filter-container {
            position: relative;
            z-index: 30;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(46, 204, 113, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            box-shadow: 0 2px 8px rgba(46, 204, 113, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .filter-group:hover {
            border-color: #2ecc71;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.2);
        }

        .filter-group svg {
            color: #2ecc71;
            flex-shrink: 0;
        }

        .filter-group select {
            background: transparent;
            border: none;
            color: #1a1a1a;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .filter-group select:focus {
            outline: none;
            ring: 0;
        }

        .filter-btn {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
            font-size: 1rem;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .filter-btn:active {
            transform: translateY(0);
        }

        /* Listing Cards */
        .listings-container {
            position: relative;
            z-index: 1;
        }

        .listing-card {
            position: relative;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid rgba(46, 204, 113, 0.1);
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .listing-card:hover {
            transform: translateY(-8px);
            border-color: #2ecc71;
            box-shadow: 0 12px 35px rgba(46, 204, 113, 0.2);
        }

        .listing-image {
            position: relative;
            height: 16rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            overflow: hidden;
        }

        .listing-card:hover .listing-image img {
            transform: scale(1.08);
        }

        .listing-image img {
            transition: transform 0.5s ease;
        }

        .price-badge {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4);
            font-size: 1.1rem;
        }

        .listing-content {
            padding: 1.5rem;
        }

        .listing-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .listing-description {
            color: #666;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .listing-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .meta-badge {
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
            color: #2ecc71;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(46, 204, 113, 0.2);
        }

        .listing-time {
            color: #999;
            font-size: 0.75rem;
            margin-top: auto;
        }

        /* Page Header */
        .page-header {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 3rem 1rem 2rem;
            animation: fadeInDown 0.8s ease;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .filter-group {
                padding: 0.625rem 1rem;
            }

            .filter-btn {
                width: 100%;
                padding: 0.875rem 1rem;
            }
        }
    </style>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50/30">
        
        {{-- Page Header --}}
        <div class="page-header">
            <h1>Visi Sludinājumi</h1>
            <p>Atklāj labākos piedāvājumus no studentiem</p>
        </div>

        {{-- Top Filter Bar --}}
        <div class="sticky top-16 filter-container">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <form method="GET" class="flex flex-wrap gap-3 items-center">
                    
                    {{-- Region --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-2" 
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" 
                                  d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" 
                                  clip-rule="evenodd" />
                        </svg>
                        <select id="region" name="region" class="focus:ring-0">
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
                             class="h-5 w-5 mr-2" 
                             viewBox="0 0 24 24" fill="none" 
                             stroke="currentColor" stroke-width="2" 
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                            <path d="M6 12v5c3 3 9 3 12 0v-5" />
                        </svg>
                        <select id="school" name="school" class="focus:ring-0">
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
                             class="h-5 w-5 mr-2" 
                             fill="none" viewBox="0 0 24 24" 
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <select id="category" name="category" class="focus:ring-0">
                            <option value="">Kategorija (visas)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Sort (NEW) --}}
                    <div class="filter-group">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-2" 
                             fill="none" viewBox="0 0 24 24" 
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <select id="sort_price" name="sort_price" class="focus:ring-0">
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
        <div class="listings-container max-w-7xl mx-auto px-6 py-10">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing) }}"
                       class="listing-card flex flex-col">
                       
                        {{-- Image --}}
                        @php $firstPhoto = $listing->photos->first(); @endphp
                        <div class="listing-image">
                            @if ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}" 
                                     alt="{{ $listing->title }}"
                                     class="h-full w-full object-contain">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-400 font-semibold">
                                     No Photo
                                </div>
                            @endif

                            {{-- Price badge overlay --}}
                            <div class="price-badge">
                                {{ number_format($listing->price, 2) }} €
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="listing-content flex flex-col flex-grow">
                            <h3 class="listing-title" title="{{ $listing->title }}">
                                {{ $listing->title }}
                            </h3>

                            <p class="listing-description" title="{{ $listing->description }}">
                                {{ $listing->description }}
                            </p>

                            {{-- Metadata badges --}}
                            <div class="listing-meta">
                                <span class="meta-badge"> {{ $listing->school->name }}</span>
                                <span class="meta-badge"> {{ $listing->category->name }}</span>
                            </div>

                            <p class="listing-time">⏰ {{ $listing->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
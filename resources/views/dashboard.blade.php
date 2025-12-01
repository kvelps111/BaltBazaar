<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        :root {
            --balt-green: #2ecc71;
            --dark: #1a1a1a;
        }

        .dashboard-wrapper {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            overflow-x: hidden;
        }

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
            background: var(--balt-green);
            opacity: 0.08;
            animation: float 20s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 250px;
            height: 250px;
            top: 10%;
            left: -125px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 180px;
            height: 180px;
            top: 40%;
            right: -90px;
            animation-delay: 3s;
            animation-duration: 15s;
        }

        .circle:nth-child(3) {
            width: 220px;
            height: 220px;
            bottom: 20%;
            left: 10%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .circle:nth-child(4) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 15%;
            animation-delay: 9s;
            animation-duration: 22s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .dashboard-content {
            position: relative;
            z-index: 1;
            padding: 2rem 1rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Hero Section */
        .hero-card {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
            margin-bottom: 2rem;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-card h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--balt-green);
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .hero-card p {
            color: #555;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .browse-btn {
            display: inline-block;
            background: var(--balt-green);
            color: #fff;
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .browse-btn:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        /* Listings Section */
        .listings-section {
            background: #fff;
            padding: 2rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            animation: slideUp 0.7s ease;
        }

        .listings-section h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
        }

        .listings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .dashboard-content {
                padding: 3rem 2rem;
            }

            .hero-card h1 {
                font-size: 2.5rem;
            }

            .hero-card p {
                font-size: 1.125rem;
            }

            .listings-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .listings-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .listings-section {
                padding: 2.5rem 2rem;
            }
        }

        /* Listing Card */
        .listing-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .listing-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
            border-color: var(--balt-green);
        }

        .listing-image {
            position: relative;
            width: 100%;
            height: 220px;
            background: #f3f4f6;
            overflow: hidden;
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .listing-card:hover .listing-image img {
            transform: scale(1.08);
        }

        .no-photo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .price-badge {
            position: absolute;
            bottom: 0.75rem;
            right: 0.75rem;
            background: var(--balt-green);
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .listing-content {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .listing-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .listing-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex-grow: 1;
        }

        .listing-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .tag {
            font-size: 0.75rem;
            color: #4b5563;
            background: #f3f4f6;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .listing-time {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: auto;
        }

        .no-listings {
            text-align: center;
            color: #6b7280;
            padding: 3rem 1rem;
            font-size: 1rem;
        }
    </style>

    <div class="dashboard-wrapper">
        <!-- Background Animation -->
        <div class="bg-animation">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>

        <!-- Content -->
        <div class="dashboard-content">
            

            <!-- Latest Listings -->
            <div class="listings-section">
                <h2>Jaunākie sludinājumi</h2>

                @if($latestListings->count())
                    <div class="listings-grid">
                        @foreach($latestListings as $listing)
                            <a href="{{ route('listings.show', $listing) }}" class="listing-card">
                                <!-- Image -->
                                @php $firstPhoto = $listing->photos->first(); @endphp
                                <div class="listing-image">
                                    @if ($firstPhoto)
                                        <img src="{{ asset('storage/' . $firstPhoto->photo) }}" 
                                             alt="{{ $listing->title }}">
                                    @else
                                        <div class="no-photo">No photo</div>
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
                                    <div class="listing-tags">
                                        <span class="tag">{{ $listing->school->name }}</span>
                                        <span class="tag">{{ $listing->category->name }}</span>
                                    </div>
                                    <p class="listing-time">{{ $listing->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="no-listings">
                        No listings available yet. Be the first to create one!
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
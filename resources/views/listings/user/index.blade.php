<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mani sludinājumi') }}
        </h2>
    </x-slot>

    <style>
        :root {
            --balt-green: #2ecc71;
            --balt-green-dark: #27ae60;
            --dark: #1a1a1a;
        }

        /* Animated Background */
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
            opacity: 0.06;
            animation: float 25s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
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

        /* Page Container */
        .listings-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 3rem 1.5rem;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.8s ease;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
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

        /* Empty State */
        .empty-state {
            max-width: 500px;
            margin: 4rem auto;
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            padding: 3rem;
            animation: fadeInUp 0.8s ease;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
        }

        .btn-create {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Listings Container */
        .listings-container {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
        }

        /* Listing Card */
        .listing-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .listing-card:hover {
            border-color: var(--balt-green);
            box-shadow: 0 8px 30px rgba(46, 204, 113, 0.15);
            transform: translateY(-2px);
        }

        /* Listing Image */
        .listing-image {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            flex-shrink: 0;
            border: 2px solid rgba(46, 204, 113, 0.1);
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .listing-image.no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        /* Listing Content */
        .listing-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .listing-header {
            margin-bottom: 1rem;
        }

        .listing-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .listing-school {
            color: var(--balt-green);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .listing-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .listing-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .price-badge {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
        }

        /* Actions */
        .listing-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn-action {
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-view {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(46, 204, 113, 0.2);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
        }

        .btn-delete {
            background: #fee;
            color: #c33;
            border: 2px solid #fcc;
        }

        .btn-delete:hover {
            background: #fdd;
            border-color: #f99;
            transform: translateY(-2px);
        }

        .btn-delete:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .listing-card {
                flex-direction: column;
                gap: 1rem;
            }

            .listing-image {
                width: 100%;
                height: 200px;
            }

            .listing-actions {
                width: 100%;
            }

            .btn-action {
                flex: 1;
                justify-content: center;
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

    <div class="listings-page bg-gradient-to-br from-gray-50 to-green-50/30">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Mani sludinājumi</h1>
            <p>Pārvaldiet savus sludinājumus un reklāmas</p>
        </div>

        @if($listings->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h2>Jums vēl nav sludinājumu</h2>
                <p>Sāciet pārdot vai noma vienumus, izveidojot savu pirmo sludinājumu.</p>
                <a href="{{ route('listings.create') }}" class="btn-create">
                    + Izveidot pirmo sludinājumu
                </a>
            </div>
        @else
            <!-- Listings Grid -->
            <div class="listings-container">
                @foreach($listings as $listing)
                    <div class="listing-card">
                        <!-- Image -->
                        <div class="listing-image">
                            @php $firstPhoto = $listing->photos->first(); @endphp
                            @if ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->photo) }}" 
                                     alt="{{ $listing->title }}">
                            @else
                                <div class="no-image">📸</div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="listing-content">
                            <div class="listing-header">
                                <h3 class="listing-title">{{ $listing->title }}</h3>
                                <p class="listing-school">{{ $listing->school->name }}</p>
                                <p class="listing-description">{{ $listing->description }}</p>
                            </div>

                            <!-- Meta Info -->
                            <div class="listing-meta">
                                <span class="meta-item">
                                     {{ $listing->category->name }}
                                </span>
                                <span class="meta-item">
                                    ⏰ {{ $listing->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Price -->
                            <div class="price-badge">
                                {{ number_format($listing->price, 2) }} €
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="listing-actions">
                            <a href="{{ route('listings.show', $listing) }}" class="btn-action btn-view">
                                 Skatīt
                            </a>

                            <form action="{{ route('listings.destroy', $listing) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Vai tiešām vēlaties dzēst šo sludinājumu?')">
                                     Dzēst
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
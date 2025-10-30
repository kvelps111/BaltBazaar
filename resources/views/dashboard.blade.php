<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Hero / Welcome -->
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <h1 class="text-3xl font-bold text-[#2ecc71] mb-4">Welcome to BaltMark!</h1>
                <p class="text-gray-700 text-lg mb-6">
                    BaltMark is a student marketplace where you can buy and sell items safely within the Baltic student community.
                </p>
                <a href="{{ route('listings.index') }}" class="inline-block bg-[#2ecc71] hover:bg-[#27ae60] text-white font-semibold px-6 py-3 rounded-lg transition">
                    Browse Listings
                </a>
            </div>

            <!-- Latest Listings -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Jaunākie sludinājumi</h2>

                @if($latestListings->count())
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($latestListings as $listing)
                            <a href="{{ route('listings.show', $listing) }}"
                               class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                                {{-- Image --}}
                                @php $firstPhoto = $listing->photos->first(); @endphp
                                <div class="relative h-64 w-full bg-gray-100 flex items-center justify-center overflow-hidden rounded-t-2xl">
                                    @if ($firstPhoto)
                                        <img src="{{ asset('storage/' . $firstPhoto->photo) }}" 
                                             alt="{{ $listing->title }}"
                                             class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105 rounded-t-2xl">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                            No photo
                                        </div>
                                    @endif

                                    {{-- Price badge overlay --}}
                                    <div class="absolute bottom-3 right-3 bg-[#2ecc71] text-white text-sm font-semibold px-3 py-1 rounded-full shadow">
                                        {{ number_format($listing->price, 2) }} €
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="{{ $listing->title }}">
                                        {{ $listing->title }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4 flex-grow truncate" title="{{ $listing->description }}">
                                        {{ $listing->description }}
                                    </p>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="text-xs text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ $listing->school->name }}</span>
                                        <span class="text-xs text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ $listing->category->name }}</span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-auto">{{ $listing->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Nav pieejamu sludinājumu.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="min-h-screen bg-gray-50">
        {{-- Top Filter Bar --}}
        <div class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <form method="GET" class="flex flex-wrap gap-4 items-center">
                    
                    {{-- Region --}}
                    <div class="flex items-center bg-gray-100 rounded-full px-4 py-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 text-gray-500 mr-2" 
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" 
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l2.707 2.707a1 1 0 101.414-1.414L11 10.586V7z" 
                                  clip-rule="evenodd" />
                        </svg>
                        <select id="region" name="region" class="bg-transparent border-none focus:ring-0 text-gray-700">
                            <option value="">Reģions (visi)</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- School --}}
                    <div class="flex items-center bg-gray-100 rounded-full px-4 py-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 text-gray-500 mr-2" 
                             viewBox="0 0 24 24" fill="none" 
                             stroke="currentColor" stroke-width="2" 
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12l-10 7L2 12l10-7 10 7z" />
                            <path d="M6 12v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7" />
                        </svg>
                        <select id="school" name="school" class="bg-transparent border-none focus:ring-0 text-gray-700">
                            <option value="">Skola (visas)</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ request('school') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="flex items-center bg-gray-100 rounded-full px-4 py-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 text-gray-500 mr-2" 
                             fill="none" viewBox="0 0 24 24" 
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M7 7h.01M7 3h10a2 2 0 012 2v4a2 2 0 01-.586 1.414l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 9V5a2 2 0 012-2h2z" />
                        </svg>
                        <select id="category" name="category" class="bg-transparent border-none focus:ring-0 text-gray-700">
                            <option value="">Kategorija (visas)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Button --}}
                    <x-primary-button
                        class="bg-[#7D9014] hover:bg-[#6b7c12] text-white font-semibold rounded-full px-6 py-2 transition transform hover:scale-105">
                        {{ __('Filtrēt') }}
                    </x-primary-button>
                </form>
            </div>
        </div>

        {{-- Listings --}}
        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($listings as $listing)
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
                            {{-- Title with ellipsis --}}
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="{{ $listing->title }}">
                                {{ $listing->title }}
                            </h3>

                            {{-- Description with ellipsis (2 lines) --}}
                            <p class="text-gray-600 text-sm mb-4 flex-grow truncate" title="{{ $listing->description }}">
                                {{ $listing->description }}
                            </p>

                            {{-- Metadata badges --}}
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="text-xs text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ $listing->school->name }}</span>
                                <span class="text-xs text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ $listing->category->name }}</span>
                            </div>

                            <p class="text-xs text-gray-400 mt-auto">{{ $listing->created_at->diffForHumans() }}</p>
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

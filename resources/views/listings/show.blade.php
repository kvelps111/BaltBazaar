<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <a href="{{ route('listings.index') }}" 
               class="inline-block mb-6 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md font-medium transition">
               ← Atpakaļ uz Sludinājumiem
            </a>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                {{-- MAIN IMAGE --}}
                @if ($listing->photos->count() > 0)
                    <div class="w-full h-[500px] bg-white border-b border-gray-200 flex items-center justify-center overflow-hidden">
                        <img id="mainImage" 
                             src="{{ asset('storage/' . $listing->photos->first()->photo) }}" 
                             alt="{{ $listing->title }}" 
                             class="max-h-full max-w-full object-contain">
                    </div>

                    {{-- THUMBNAILS --}}
                    @if($listing->photos->count() > 1)
                        <div class="flex gap-3 p-4 overflow-x-auto bg-gray-50 border-b border-gray-200">
                            @foreach($listing->photos as $index => $photo)
                                <img src="{{ asset('storage/' . $photo->photo) }}" 
                                     data-index="{{ $index }}"
                                     class="thumb cursor-pointer h-20 w-24 object-cover rounded-md border border-gray-200 hover:border-[#2ecc71] transition">
                            @endforeach
                        </div>
                    @endif
                @endif

                {{-- LISTING INFO --}}
                <div class="p-6 flex flex-col space-y-5">
                    <!-- Title (full, wraps) -->
                    <h1 class="text-2xl font-bold text-gray-900 break-words">
                        {{ $listing->title }}
                    </h1>

                    <!-- Description (full, wraps, respects line breaks) -->
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed break-words">
                        {{ $listing->description }}
                    </p>

                    <!-- Price + Badges -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <p class="text-2xl font-bold text-[#2ecc71]">
                            {{ number_format($listing->price, 2) }} €
                        </p>
                        <div class="flex gap-2">
                            <span class="text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $listing->school->name }}
                            </span>
                            <span class="text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $listing->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Published Date -->
                    <p class="text-gray-500 text-sm">
                        Publicēts: {{ $listing->created_at->format('d.m.Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const images = @json($listing->photos->pluck('photo'));
        let currentIndex = 0;

        const mainImg = document.getElementById("mainImage");
        const thumbs = document.querySelectorAll(".thumb");

        thumbs.forEach(thumb => {
            thumb.addEventListener("click", () => {
                currentIndex = parseInt(thumb.dataset.index);
                updateImage();
            });
        });

        function updateImage() {
            if(mainImg) {
                mainImg.src = `/storage/${images[currentIndex]}`;
            }
        }
    </script>
</x-app-layout>

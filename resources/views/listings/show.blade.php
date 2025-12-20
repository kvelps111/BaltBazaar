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

                    <!-- Owner Contact Information -->
                    <div class="border-t pt-4 mt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Kontaktinformācija</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">
                                <span class="font-medium">Pārdevējs:</span> {{ $listing->user->name }}
                            </p>
                            @if($listing->user->phone_number)
                                <p class="text-gray-700 mt-2">
                                    <span class="font-medium">Telefons:</span>
                                    <a href="tel:{{ $listing->user->phone_number }}" class="text-[#2ecc71] hover:underline">
                                        {{ $listing->user->phone_number }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Report Button -->
                    @auth
                        @if(auth()->id() !== $listing->user_id)
                            <div class="border-t pt-4 mt-4">
                                <button onclick="document.getElementById('reportModal').classList.remove('hidden')"
                                        class="text-sm text-red-600 hover:text-red-700 hover:underline">
                                    🚩 Ziņot par šo sludinājumu
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ziņot par sludinājumu</h3>

            <form method="POST" action="{{ route('listings.report', $listing) }}">
                @csrf

                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Iemesls <span class="text-red-500">*</span>
                    </label>
                    <select name="reason" id="reason" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Izvēlies iemeslu</option>
                        <option value="Krāpšana">Krāpšana</option>
                        <option value="Neatbilstošs saturs">Neatbilstošs saturs</option>
                        <option value="Nepareiza kategorija">Nepareiza kategorija</option>
                        <option value="Dublikāts">Dublikāts</option>
                        <option value="Cits">Cits</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Papildu informācija
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Apraksti problēmu..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="document.getElementById('reportModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                        Atcelt
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                        Nosūtīt ziņojumu
                    </button>
                </div>
            </form>
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

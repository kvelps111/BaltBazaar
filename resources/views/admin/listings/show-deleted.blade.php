<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.listings.deleted') }}"
                   class="admin-btn-secondary">
                    ← Back to Deleted Listings
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Photos Section -->
                    <div class="admin-section mb-6">
                        <h2 class="admin-section-title">Photos ({{ $listing->photos->count() }})</h2>
                        <div class="admin-section-content">
                            @if ($listing->photos->count() > 0)
                                {{-- MAIN IMAGE --}}
                                <div class="w-full h-[500px] bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden mb-4">
                                    <img id="mainImage"
                                         src="{{ asset('storage/' . $listing->photos->first()->photo) }}"
                                         alt="{{ $listing->title }}"
                                         class="max-h-full max-w-full object-contain">
                                </div>

                                {{-- THUMBNAILS GRID --}}
                                @if($listing->photos->count() > 1)
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach($listing->photos as $index => $photo)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $photo->photo) }}"
                                                     data-index="{{ $index }}"
                                                     class="thumb cursor-pointer w-full h-24 object-cover rounded-lg border-2 border-gray-200 hover:border-red-500 transition">
                                                <span class="absolute top-1 right-1 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                                                    {{ $index + 1 }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <span class="text-4xl">📦</span>
                                    <p class="mt-2">No photos available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Listing Details -->
                    <div class="admin-section">
                        <h2 class="admin-section-title">Listing Information</h2>
                        <div class="admin-section-content">
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Title:</span>
                                <span class="admin-detail-value">{{ $listing->title }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Price:</span>
                                <span class="admin-detail-value">{{ number_format($listing->price, 2) }} €</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Category:</span>
                                <span class="admin-detail-value">{{ $listing->category->name }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">School:</span>
                                <span class="admin-detail-value">{{ $listing->school->name }}</span>
                            </div>
                            <div class="border-t border-gray-100 pt-4 mt-4">
                                <p class="admin-detail-label mb-2">Description:</p>
                                <p class="text-gray-900 whitespace-pre-line">{{ $listing->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Timeline -->
                    <div class="admin-section mb-6">
                        <h2 class="admin-section-title">Timeline</h2>
                        <div class="admin-section-content space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Created</p>
                                    <p class="text-xs text-gray-500">{{ $listing->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            @if($listing->updated_at != $listing->created_at)
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                        <p class="text-xs text-gray-500">{{ $listing->updated_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Deleted</p>
                                    <p class="text-xs text-gray-500">{{ $listing->deleted_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="admin-section">
                        <h2 class="admin-section-title">User Information</h2>
                        <div class="admin-section-content">
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Name:</span>
                                <span class="admin-detail-value">
                                    <a href="{{ route('admin.users.show', $listing->user) }}"
                                       class="text-green-600 hover:underline">
                                        {{ $listing->user->name }}
                                    </a>
                                </span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Email:</span>
                                <span class="admin-detail-value">{{ $listing->user->email }}</span>
                            </div>
                            @if($listing->user->phone_number)
                                <div class="admin-detail-row">
                                    <span class="admin-detail-label">Phone:</span>
                                    <span class="admin-detail-value">{{ $listing->user->phone_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
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

                // Update active state
                thumbs.forEach(t => t.classList.remove('border-red-500'));
                thumb.classList.add('border-red-500');
            });
        });

        function updateImage() {
            if(mainImg) {
                mainImg.src = `/storage/${images[currentIndex]}`;
            }
        }

        // Set first thumbnail as active
        if(thumbs.length > 0) {
            thumbs[0].classList.add('border-red-500');
        }
    </script>
</x-app-layout>

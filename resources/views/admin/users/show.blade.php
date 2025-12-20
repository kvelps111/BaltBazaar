<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">User Details</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">{{ $user->name }}</h1>
                <p class="admin-subtitle">View and manage user details</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}"
                   class="admin-btn-secondary">
                    ← Back to Users
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Details -->
                <div class="lg:col-span-2">
                    <div class="admin-section">
                        <h2 class="admin-section-title">User Information</h2>
                        <div class="admin-section-content">
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">User ID:</span>
                                <span class="admin-detail-value">#{{ $user->id }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Name:</span>
                                <span class="admin-detail-value">{{ $user->name }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Email:</span>
                                <span class="admin-detail-value">{{ $user->email }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Phone Number:</span>
                                <span class="admin-detail-value">{{ $user->phone_number ?? 'N/A' }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Role:</span>
                                @if($user->is_admin)
                                    <span class="admin-badge-resolved">Admin</span>
                                @else
                                    <span class="admin-badge-dismissed">User</span>
                                @endif
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Email Verified:</span>
                                @if($user->email_verified_at)
                                    <span class="admin-badge-resolved">
                                        Verified on {{ $user->email_verified_at->format('d.m.Y') }}
                                    </span>
                                @else
                                    <span class="admin-badge-pending">Not Verified</span>
                                @endif
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Joined:</span>
                                <span class="admin-detail-value">
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                    ({{ $user->created_at->diffForHumans() }})
                                </span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Total Listings:</span>
                                <span class="admin-detail-value">{{ $user->listings->count() }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Total Reports:</span>
                                <span class="admin-detail-value">{{ $user->reports->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- User's Listings -->
                    <div class="admin-section">
                        <h2 class="admin-section-title">User's Listings ({{ $user->listings->count() }})</h2>
                        <div class="admin-section-content">
                            @if($user->listings->count())
                                <div class="space-y-4">
                                    @foreach($user->listings as $listing)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-colors">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 mb-2">
                                                        <a href="{{ route('listings.show', $listing) }}"
                                                           target="_blank"
                                                           class="hover:text-green-600">
                                                            {{ $listing->title }}
                                                        </a>
                                                    </h3>
                                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                        {{ $listing->description }}
                                                    </p>
                                                    <div class="flex flex-wrap gap-2 text-sm">
                                                        <span class="admin-badge-active">
                                                            {{ number_format($listing->price, 2) }} €
                                                        </span>
                                                        <span class="admin-badge-dismissed">
                                                            {{ $listing->school->name }}
                                                        </span>
                                                        <span class="admin-badge-dismissed">
                                                            {{ $listing->category->name }}
                                                        </span>
                                                        <span class="text-gray-500">
                                                            {{ $listing->created_at->format('d.m.Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex gap-2">
                                                    <a href="{{ route('listings.show', $listing) }}"
                                                       target="_blank"
                                                       class="admin-btn-sm-primary">
                                                        View
                                                    </a>
                                                    <form action="{{ route('admin.listings.destroy', $listing) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="admin-btn-sm-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="admin-empty-state">
                                    <div class="admin-empty-icon">📦</div>
                                    <h3 class="admin-empty-title">No listings</h3>
                                    <p class="admin-empty-description">This user hasn't created any listings yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User's Reports -->
                    <div class="admin-section">
                        <h2 class="admin-section-title">Reports Made by User ({{ $user->reports->count() }})</h2>
                        <div class="admin-section-content">
                            @if($user->reports->count())
                                <div class="space-y-3">
                                    @foreach($user->reports as $report)
                                        <div class="border border-gray-200 rounded-lg p-3">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $report->reason }}</p>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        Listing: {{ $report->listing->title ?? 'Deleted' }}
                                                    </p>
                                                    <div class="flex gap-2 mt-2">
                                                        <span class="admin-badge-{{ $report->status }}">
                                                            {{ ucfirst($report->status) }}
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            {{ $report->created_at->format('d.m.Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.reports.show', $report) }}"
                                                   class="admin-btn-sm-secondary">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="admin-empty-state">
                                    <div class="admin-empty-icon">✅</div>
                                    <h3 class="admin-empty-title">No reports</h3>
                                    <p class="admin-empty-description">This user hasn't made any reports</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions Sidebar -->
                <div class="lg:col-span-1">
                    <div class="admin-section">
                        <h2 class="admin-section-title">Actions</h2>
                        <div class="admin-section-content space-y-4">
                            @if(!$user->is_admin)
                                <!-- Ban User Button -->
                                <button onclick="document.getElementById('banModal').classList.remove('hidden')"
                                        class="admin-btn-danger w-full">
                                    Ban User
                                </button>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm text-yellow-800">
                                        ⚠️ This is an admin account and cannot be banned.
                                    </p>
                                </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <h3 class="font-medium text-gray-900 mb-3">Quick Stats</h3>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Listings:</span>
                                    <span class="font-semibold">{{ $user->listings->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Reports Made:</span>
                                    <span class="font-semibold">{{ $user->reports->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Member Since:</span>
                                    <span class="font-semibold">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ban User Modal -->
    <div id="banModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ban User</h3>
            <p class="text-gray-600 mb-4">
                This will permanently ban {{ $user->name }} and delete all their listings. They will not be able to register again with the same email or phone number.
            </p>

            <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                @csrf

                <div class="admin-form-group">
                    <label for="reason" class="admin-form-label">
                        Reason <span class="text-red-500">*</span>
                    </label>
                    <select name="reason" id="reason" required class="admin-form-select">
                        <option value="">Select a reason</option>
                        <option value="Spam">Spam</option>
                        <option value="Fraud">Fraud/Scam</option>
                        <option value="Inappropriate Content">Inappropriate Content</option>
                        <option value="Harassment">Harassment</option>
                        <option value="Multiple Violations">Multiple Violations</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label for="notes" class="admin-form-label">
                        Additional Notes
                    </label>
                    <textarea name="notes" id="notes" rows="3" class="admin-form-textarea"
                              placeholder="Any additional information..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="document.getElementById('banModal').classList.add('hidden')"
                            class="flex-1 admin-btn-secondary">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 admin-btn-danger">
                        Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

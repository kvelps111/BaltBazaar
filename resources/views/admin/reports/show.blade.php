<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Report Details</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">Report #{{ $report->id }}</h1>
                <p class="admin-subtitle">View and manage report details</p>
            </div>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.reports.index') }}"
                   class="admin-btn-secondary">
                    ← Back to Reports
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Report Details -->
                <div class="lg:col-span-2">
                    <div class="admin-section">
                        <h2 class="admin-section-title">Report Information</h2>
                        <div class="admin-section-content">
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Report ID:</span>
                                <span class="admin-detail-value">#{{ $report->id }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Reported By:</span>
                                <span class="admin-detail-value">
                                    <a href="{{ route('admin.users.show', $report->user) }}"
                                       class="text-green-600 hover:underline">
                                        {{ $report->user->name }}
                                    </a>
                                </span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Reason:</span>
                                <span class="admin-detail-value">{{ $report->reason }}</span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Status:</span>
                                <span class="admin-badge-{{ $report->status }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                            <div class="admin-detail-row">
                                <span class="admin-detail-label">Date:</span>
                                <span class="admin-detail-value">
                                    {{ $report->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            @if($report->description)
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <p class="admin-detail-label mb-2">Description:</p>
                                    <p class="text-gray-900">{{ $report->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Listing Details -->
                    <div class="admin-section">
                        <h2 class="admin-section-title">Reported Listing</h2>
                        <div class="admin-section-content">
                            @if($report->listing)
                                <div class="admin-detail-row">
                                    <span class="admin-detail-label">Title:</span>
                                    <span class="admin-detail-value">{{ $report->listing->title }}</span>
                                </div>
                                <div class="admin-detail-row">
                                    <span class="admin-detail-label">Owner:</span>
                                    <span class="admin-detail-value">
                                        <a href="{{ route('admin.users.show', $report->listing->user) }}"
                                           class="text-green-600 hover:underline">
                                            {{ $report->listing->user->name }}
                                        </a>
                                    </span>
                                </div>
                                <div class="admin-detail-row">
                                    <span class="admin-detail-label">Price:</span>
                                    <span class="admin-detail-value">
                                        {{ number_format($report->listing->price, 2) }} €
                                    </span>
                                </div>
                                <div class="admin-detail-row">
                                    <span class="admin-detail-label">School:</span>
                                    <span class="admin-detail-value">{{ $report->listing->school->name }}</span>
                                </div>
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <p class="admin-detail-label mb-2">Description:</p>
                                    <p class="text-gray-900">{{ $report->listing->description }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <a href="{{ route('listings.show', $report->listing) }}"
                                       target="_blank"
                                       class="admin-btn-primary">
                                        View Listing
                                    </a>
                                </div>
                            @else
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                This listing has been deleted and is no longer available.
                                            </p>
                                        </div>
                                    </div>
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
                            <!-- Update Status Form -->
                            <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="admin-form-group">
                                    <label for="status" class="admin-form-label">Update Status</label>
                                    <select name="status" id="status" class="admin-form-select">
                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>
                                            Reviewed
                                        </option>
                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>
                                            Resolved
                                        </option>
                                        <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>
                                            Dismissed
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="admin-btn-primary w-full">
                                    Update Status
                                </button>
                            </form>

                            <!-- Delete Report -->
                            <form action="{{ route('admin.reports.destroy', $report) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this report?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn-danger w-full">
                                    Delete Report
                                </button>
                            </form>

                            <!-- Delete Listing -->
                            @if($report->listing)
                                <form action="{{ route('admin.listings.destroy', $report->listing) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this listing? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn-danger w-full">
                                        Delete Listing
                                    </button>
                                </form>
                            @else
                                <button type="button" class="admin-btn-danger w-full opacity-50 cursor-not-allowed" disabled>
                                    Listing Already Deleted
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

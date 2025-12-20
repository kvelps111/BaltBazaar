<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Admin Dashboard</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">Admin Dashboard</h1>
                <p class="admin-subtitle">Pārvaldiet savu platformu un lietotājus</p>
            </div>

            <!-- Navigation -->
            <nav class="admin-nav">
                <ul class="admin-nav-list">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item-active">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="admin-nav-item-inactive">
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="admin-nav-item-inactive">
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.listings.index') }}" class="admin-nav-item-inactive">
                            Listings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.listings.deleted') }}" class="admin-nav-item-inactive">
                            Deleted Listings
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Statistics Grid -->
            <div class="admin-stats-grid">
                <!-- Total Users -->
                <div class="admin-stat-card-blue">
                    <div class="admin-stat-label">Total Users</div>
                    <div class="admin-stat-value">{{ $stats['total_users'] }}</div>
                </div>

                <!-- Active Users -->
                <div class="admin-stat-card-green">
                    <div class="admin-stat-label">Active Users (30d)</div>
                    <div class="admin-stat-value">{{ $stats['active_users'] }}</div>
                </div>

                <!-- Total Listings -->
                <div class="admin-stat-card-purple">
                    <div class="admin-stat-label">Total Listings</div>
                    <div class="admin-stat-value">{{ $stats['total_listings'] }}</div>
                </div>

                <!-- Pending Reports -->
                <div class="admin-stat-card-red">
                    <div class="admin-stat-label">Pending Reports</div>
                    <div class="admin-stat-value">{{ $stats['pending_reports'] }}</div>
                </div>

                <!-- Active Listings -->
                <div class="admin-stat-card-yellow">
                    <div class="admin-stat-label">New Listings (30d)</div>
                    <div class="admin-stat-value">{{ $stats['active_listings'] }}</div>
                </div>

                <!-- Total Reports -->
                <div class="admin-stat-card-purple">
                    <div class="admin-stat-label">Total Reports</div>
                    <div class="admin-stat-value">{{ $stats['total_reports'] }}</div>
                </div>

                <!-- Banned Users -->
                <div class="admin-stat-card-red">
                    <div class="admin-stat-label">Banned Users</div>
                    <div class="admin-stat-value">{{ $stats['banned_users'] }}</div>
                </div>
            </div>

            <!-- Recent Pending Reports -->
            <div class="admin-section">
                <h2 class="admin-section-title">Recent Pending Reports</h2>
                <div class="admin-section-content">
                    @if($recentReports->count())
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead class="admin-table-header">
                                    <tr>
                                        <th class="admin-table-th">Listing</th>
                                        <th class="admin-table-th">Reported By</th>
                                        <th class="admin-table-th">Reason</th>
                                        <th class="admin-table-th">Date</th>
                                        <th class="admin-table-th">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="admin-table-body">
                                    @foreach($recentReports as $report)
                                        <tr class="admin-table-row">
                                            <td class="admin-table-td">
                                                @if($report->listing)
                                                    <a href="{{ route('listings.show', $report->listing) }}"
                                                       class="text-green-600 hover:underline">
                                                        {{ Str::limit($report->listing->title, 40) }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-500 italic">[Listing Deleted]</span>
                                                @endif
                                            </td>
                                            <td class="admin-table-td">{{ $report->user->name }}</td>
                                            <td class="admin-table-td">{{ $report->reason }}</td>
                                            <td class="admin-table-td">{{ $report->created_at->format('d.m.Y') }}</td>
                                            <td class="admin-table-td">
                                                <a href="{{ route('admin.reports.show', $report) }}"
                                                   class="admin-btn-sm-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="admin-empty-state">
                            <div class="admin-empty-icon">✅</div>
                            <h3 class="admin-empty-title">No pending reports</h3>
                            <p class="admin-empty-description">All reports have been reviewed</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Listings -->
            <div class="admin-section">
                <h2 class="admin-section-title">Recent Listings</h2>
                <div class="admin-section-content">
                    @if($recentListings->count())
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead class="admin-table-header">
                                    <tr>
                                        <th class="admin-table-th">Title</th>
                                        <th class="admin-table-th">User</th>
                                        <th class="admin-table-th">School</th>
                                        <th class="admin-table-th">Price</th>
                                        <th class="admin-table-th">Date</th>
                                        <th class="admin-table-th">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="admin-table-body">
                                    @foreach($recentListings as $listing)
                                        <tr class="admin-table-row">
                                            <td class="admin-table-td">
                                                <a href="{{ route('listings.show', $listing) }}"
                                                   class="text-green-600 hover:underline">
                                                    {{ Str::limit($listing->title, 40) }}
                                                </a>
                                            </td>
                                            <td class="admin-table-td">{{ $listing->user->name }}</td>
                                            <td class="admin-table-td">{{ $listing->school->name }}</td>
                                            <td class="admin-table-td">{{ number_format($listing->price, 2) }} €</td>
                                            <td class="admin-table-td">{{ $listing->created_at->format('d.m.Y') }}</td>
                                            <td class="admin-table-td">
                                                <a href="{{ route('listings.show', $listing) }}"
                                                   class="admin-btn-sm-secondary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="admin-empty-state">
                            <div class="admin-empty-icon">📦</div>
                            <h3 class="admin-empty-title">No listings yet</h3>
                            <p class="admin-empty-description">Listings will appear here once created</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

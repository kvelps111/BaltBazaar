<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Reports Management</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">Reports Management</h1>
                <p class="admin-subtitle">Pārvaldiet visus ziņojumus</p>
            </div>

            <!-- Navigation -->
            <nav class="admin-nav">
                <ul class="admin-nav-list">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item-inactive">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="admin-nav-item-active">
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

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reports Table -->
            <div class="admin-table-container">
                @if($reports->count())
                    <table class="admin-table">
                        <thead class="admin-table-header">
                            <tr>
                                <th class="admin-table-th">ID</th>
                                <th class="admin-table-th">Listing</th>
                                <th class="admin-table-th">Reported By</th>
                                <th class="admin-table-th">Reason</th>
                                <th class="admin-table-th">Status</th>
                                <th class="admin-table-th">Date</th>
                                <th class="admin-table-th">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table-body">
                            @foreach($reports as $report)
                                <tr class="admin-table-row">
                                    <td class="admin-table-td font-medium text-gray-900">
                                        #{{ $report->id }}
                                    </td>
                                    <td class="admin-table-td">
                                        @if($report->listing)
                                            <a href="{{ route('listings.show', $report->listing) }}"
                                               class="text-green-600 hover:underline"
                                               target="_blank">
                                                {{ Str::limit($report->listing->title, 40) }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 italic">[Listing Deleted]</span>
                                        @endif
                                    </td>
                                    <td class="admin-table-td">
                                        {{ $report->user->name }}
                                    </td>
                                    <td class="admin-table-td">
                                        {{ $report->reason }}
                                    </td>
                                    <td class="admin-table-td">
                                        <span class="admin-badge-{{ $report->status }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="admin-table-td text-gray-600">
                                        {{ $report->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="admin-table-td">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.reports.show', $report) }}"
                                               class="admin-btn-sm-primary">
                                                View
                                            </a>
                                            <form action="{{ route('admin.reports.destroy', $report) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this report?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn-sm-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="admin-pagination">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="admin-empty-state">
                        <div class="admin-empty-icon">✅</div>
                        <h3 class="admin-empty-title">No reports found</h3>
                        <p class="admin-empty-description">There are no reports in the system</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

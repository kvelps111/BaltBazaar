<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">Users Management</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-8">
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">Users Management</h1>
                <p class="admin-subtitle">Pārvaldiet visus lietotājus</p>
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
                        <a href="{{ route('admin.reports.index') }}" class="admin-nav-item-inactive">
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="admin-nav-item-active">
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

            <!-- Users Table -->
            <div class="admin-table-container">
                @if($users->count())
                    <table class="admin-table">
                        <thead class="admin-table-header">
                            <tr>
                                <th class="admin-table-th">ID</th>
                                <th class="admin-table-th">Name</th>
                                <th class="admin-table-th">Email</th>
                                <th class="admin-table-th">Phone</th>
                                <th class="admin-table-th">Listings</th>
                                <th class="admin-table-th">Admin</th>
                                <th class="admin-table-th">Joined</th>
                                <th class="admin-table-th">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table-body">
                            @foreach($users as $user)
                                <tr class="admin-table-row">
                                    <td class="admin-table-td font-medium text-gray-900">
                                        #{{ $user->id }}
                                    </td>
                                    <td class="admin-table-td font-medium">
                                        {{ $user->name }}
                                    </td>
                                    <td class="admin-table-td text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="admin-table-td text-gray-600">
                                        {{ $user->phone_number ?? 'N/A' }}
                                    </td>
                                    <td class="admin-table-td">
                                        <span class="admin-badge-active">
                                            {{ $user->listings_count }} listings
                                        </span>
                                    </td>
                                    <td class="admin-table-td">
                                        @if($user->is_admin)
                                            <span class="admin-badge-resolved">Admin</span>
                                        @else
                                            <span class="admin-badge-dismissed">User</span>
                                        @endif
                                    </td>
                                    <td class="admin-table-td text-gray-600">
                                        {{ $user->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="admin-table-td">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="admin-btn-sm-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="admin-pagination">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="admin-empty-state">
                        <div class="admin-empty-icon">👥</div>
                        <h3 class="admin-empty-title">No users found</h3>
                        <p class="admin-empty-description">There are no users in the system</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

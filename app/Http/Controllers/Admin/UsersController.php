<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BannedUser;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::withCount('listings')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['listings', 'reports']);
        return view('admin.users.show', compact('user'));
    }

    public function ban(Request $request, User $user)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        BannedUser::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number,
            'email' => $user->email,
            'reason' => $validated['reason'],
            'notes' => $validated['notes'] ?? null,
            'banned_by' => auth()->id(),
        ]);

        // Delete user's listings
        $user->listings()->delete();

        // Delete the user account
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User has been banned successfully.');
    }
}

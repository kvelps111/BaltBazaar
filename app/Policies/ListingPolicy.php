<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;
    
    class ListingPolicy
    {
        /**
         * Determine whether the user can view any models.
         */
        public function viewAny(User $user): bool
    {
        return true; // anyone logged in can see listings
    }
    
    public function view(User $user, Listing $listing): bool
    {
        return true; // anyone logged in can view a single listing
    }
    
    public function create(User $user): bool
    {
        return true; // anyone logged in can create
    }
    
    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id; // only owner can update
    }
    
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id; // only owner can delete
    }
    
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return false;
    }
}

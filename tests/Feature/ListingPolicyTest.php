<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function any_authenticated_user_can_create_listing()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $this->assertTrue($user->can('create', Listing::class));
    }

    /** @test */
    public function guest_cannot_create_listing()
    {
        $this->assertFalse(auth()->guest() || !auth()->check());
    }

    /** @test */
    public function user_can_delete_their_own_listing()
    {
        $user = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $this->assertTrue($user->can('delete', $listing));
    }

    /** @test */
    public function user_cannot_delete_another_users_listing()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);

        $this->assertFalse($user->can('delete', $listing));
    }

    /** @test */
    public function user_can_view_any_listing()
    {
        $user = User::factory()->create();
        $listing = Listing::factory()->create();

        $this->actingAs($user);

        $this->assertTrue($user->can('view', $listing));
    }
}
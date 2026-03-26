<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Models\ListingPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminListingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected School $school;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin'          => true,
            'phone_verified_at' => now(),
        ]);

        $this->user = User::factory()->create([
            'is_admin'          => false,
            'phone_verified_at' => now(),
        ]);

        $this->school   = School::factory()->create(['region' => 'Rīga']);
        $this->category = Category::factory()->create();
    }

    private function makeListing(array $overrides = []): Listing
    {
        return Listing::factory()->create(array_merge([
            'school_id'   => $this->school->id,
            'category_id' => $this->category->id,
            'user_id'     => $this->user->id,
        ], $overrides));
    }

    // ── Access control — index ─────────────────────────────────────────

    public function test_guest_cannot_access_admin_listings_index()
    {
        $response = $this->get(route('admin.listings.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_listings_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.listings.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_listings_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index'));

        $response->assertOk();
        $response->assertViewIs('admin.listings.index');
    }

    // ── Index content ─────────────────────────────────────────────────

    public function test_admin_listings_index_shows_all_listings()
    {
        $l1 = $this->makeListing(['title' => 'Alpha Listing']);
        $l2 = $this->makeListing(['title' => 'Beta Listing']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index'));

        $response->assertSee('Alpha Listing');
        $response->assertSee('Beta Listing');
    }

    public function test_admin_listings_index_passes_filter_data_to_view()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index'));

        $response->assertViewHas('regions');
        $response->assertViewHas('schools');
        $response->assertViewHas('categories');
        $response->assertViewHas('listings');
    }

    public function test_admin_can_filter_listings_by_region()
    {
        $rigaSchool    = School::factory()->create(['region' => 'Rīga']);
        $jelgavaSchool = School::factory()->create(['region' => 'Zemgale']);

        $rigaListing    = $this->makeListing(['school_id' => $rigaSchool->id, 'title' => 'Riga Item']);
        $jelgavaListing = $this->makeListing(['school_id' => $jelgavaSchool->id, 'title' => 'Jelgava Item']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index', ['region' => 'Rīga']));

        $response->assertSee('Riga Item');
        $response->assertDontSee('Jelgava Item');
    }

    public function test_admin_can_filter_listings_by_school()
    {
        $school2 = School::factory()->create();

        $l1 = $this->makeListing(['school_id' => $this->school->id, 'title' => 'School One Item']);
        $l2 = $this->makeListing(['school_id' => $school2->id, 'title' => 'School Two Item']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index', ['school' => $this->school->id]));

        $response->assertSee('School One Item');
        $response->assertDontSee('School Two Item');
    }

    public function test_admin_can_filter_listings_by_category()
    {
        $cat2 = Category::factory()->create();

        $l1 = $this->makeListing(['category_id' => $this->category->id, 'title' => 'Cat One Item']);
        $l2 = $this->makeListing(['category_id' => $cat2->id, 'title' => 'Cat Two Item']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index', ['category' => $this->category->id]));

        $response->assertSee('Cat One Item');
        $response->assertDontSee('Cat Two Item');
    }

    public function test_admin_can_sort_listings_by_price_asc()
    {
        $this->makeListing(['price' => 50]);
        $this->makeListing(['price' => 10]);
        $this->makeListing(['price' => 30]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index', ['sort_price' => 'asc']));

        $listings = $response->viewData('listings');
        $this->assertEquals(10, $listings->first()->price);
    }

    public function test_admin_can_sort_listings_by_price_desc()
    {
        $this->makeListing(['price' => 50]);
        $this->makeListing(['price' => 10]);
        $this->makeListing(['price' => 30]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index', ['sort_price' => 'desc']));

        $listings = $response->viewData('listings');
        $this->assertEquals(50, $listings->first()->price);
    }

    // ── Delete listing ─────────────────────────────────────────────────

    public function test_admin_can_delete_any_listing()
    {
        $listing = $this->makeListing();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.listings.destroy', $listing));

        $response->assertRedirect(route('admin.listings.index'));
        $response->assertSessionHas('success');
        $this->assertSoftDeleted('listings', ['id' => $listing->id]);
    }

    public function test_admin_can_delete_listing_belonging_to_any_user()
    {
        $anotherUser = User::factory()->create(['phone_verified_at' => now()]);
        $listing     = $this->makeListing(['user_id' => $anotherUser->id]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.listings.destroy', $listing));

        $this->assertSoftDeleted('listings', ['id' => $listing->id]);
    }

    public function test_regular_user_cannot_delete_listing_via_admin_route()
    {
        $listing = $this->makeListing();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.listings.destroy', $listing));

        $response->assertForbidden();
        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'deleted_at' => null]);
    }

    public function test_guest_cannot_delete_listing_via_admin_route()
    {
        $listing = $this->makeListing();

        $response = $this->delete(route('admin.listings.destroy', $listing));

        $response->assertRedirect(route('login'));
    }

    // ── Deleted listings ──────────────────────────────────────────────

    public function test_guest_cannot_access_deleted_listings()
    {
        $response = $this->get(route('admin.listings.deleted'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_deleted_listings()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.listings.deleted'));

        $response->assertForbidden();
    }

    public function test_admin_can_view_deleted_listings()
    {
        $listing = $this->makeListing(['title' => 'Deleted Item']);
        $listing->delete();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.deleted'));

        $response->assertOk();
        $response->assertViewIs('admin.listings.deleted');
        $response->assertSee('Deleted Item');
    }

    public function test_deleted_listings_page_does_not_show_active_listings()
    {
        $active  = $this->makeListing(['title' => 'Active Item']);
        $deleted = $this->makeListing(['title' => 'Deleted Item']);
        $deleted->delete();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.deleted'));

        $response->assertSee('Deleted Item');
        $response->assertDontSee('Active Item');
    }

    // ── Show deleted listing ──────────────────────────────────────────

    public function test_admin_can_view_single_deleted_listing()
    {
        $listing = $this->makeListing(['title' => 'Soft Deleted Item']);
        $listing->delete();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.deleted.show', $listing->id));

        $response->assertOk();
        $response->assertViewIs('admin.listings.show-deleted');
        $response->assertSee('Soft Deleted Item');
    }

    public function test_show_deleted_returns_404_for_active_listing()
    {
        $listing = $this->makeListing();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.deleted.show', $listing->id));

        $response->assertNotFound();
    }

    public function test_guest_cannot_view_single_deleted_listing()
    {
        $listing = $this->makeListing();
        $listing->delete();

        $response = $this->get(route('admin.listings.deleted.show', $listing->id));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_view_single_deleted_listing()
    {
        $listing = $this->makeListing();
        $listing->delete();

        $response = $this->actingAs($this->user)
            ->get(route('admin.listings.deleted.show', $listing->id));

        $response->assertForbidden();
    }

    // ── Pagination ────────────────────────────────────────────────────

    public function test_admin_listings_index_is_paginated_at_15()
    {
        Listing::factory()->count(20)->create([
            'school_id'   => $this->school->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.index'));

        $listings = $response->viewData('listings');
        $this->assertEquals(15, $listings->count());
    }

    public function test_admin_deleted_listings_is_paginated_at_15()
    {
        $listings = Listing::factory()->count(20)->create([
            'school_id'   => $this->school->id,
            'category_id' => $this->category->id,
        ]);

        foreach ($listings as $listing) {
            $listing->delete();
        }

        $response = $this->actingAs($this->admin)
            ->get(route('admin.listings.deleted'));

        $this->assertEquals(15, $response->viewData('listings')->count());
    }
}
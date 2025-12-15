<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ListingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $school;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->school = School::factory()->create([
            'region' => 'Rīga',
            'name' => 'Test School'
        ]);
        $this->category = Category::factory()->create(['name' => 'Books']);
    }

    public function test_guest_cannot_view_listings_index()
    {
        $response = $this->get(route('listings.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_listings_index()
    {
        Listing::factory()->count(3)->create([
            'school_id' => $this->school->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->get(route('listings.index'));

        $response->assertOk();
        $response->assertViewIs('listings.index');
        $response->assertViewHas('listings');
        $response->assertViewHas('regions');
        $response->assertViewHas('schools');
        $response->assertViewHas('categories');
    }

    public function test_listings_can_be_filtered_by_region()
    {
        $school1 = School::factory()->create(['region' => 'Rīga']);
        $school2 = School::factory()->create(['region' => 'Daugavpils']);

        $listing1 = Listing::factory()->create(['school_id' => $school1->id]);
        $listing2 = Listing::factory()->create(['school_id' => $school2->id]);

        $response = $this->actingAs($this->user)->get(route('listings.index', ['region' => 'Rīga']));

        $response->assertOk();
        $response->assertSee($listing1->title);
        $response->assertDontSee($listing2->title);
    }

    public function test_listings_can_be_filtered_by_school()
    {
        $listing1 = Listing::factory()->create(['school_id' => $this->school->id]);
        $otherSchool = School::factory()->create();
        $listing2 = Listing::factory()->create(['school_id' => $otherSchool->id]);

        $response = $this->actingAs($this->user)->get(route('listings.index', ['school' => $this->school->id]));

        $response->assertOk();
        $response->assertSee($listing1->title);
        $response->assertDontSee($listing2->title);
    }

    public function test_listings_can_be_filtered_by_category()
    {
        $listing1 = Listing::factory()->create(['category_id' => $this->category->id]);
        $otherCategory = Category::factory()->create();
        $listing2 = Listing::factory()->create(['category_id' => $otherCategory->id]);

        $response = $this->actingAs($this->user)->get(route('listings.index', ['category' => $this->category->id]));

        $response->assertOk();
        $response->assertSee($listing1->title);
        $response->assertDontSee($listing2->title);
    }

    public function test_listings_can_be_sorted_by_price()
    {
        Listing::factory()->create(['price' => 30]);
        Listing::factory()->create(['price' => 10]);
        Listing::factory()->create(['price' => 20]);

        $response = $this->actingAs($this->user)->get(route('listings.index', ['sort_price' => 'asc']));

        $response->assertOk();
        $listings = $response->viewData('listings');
        $this->assertEquals(10, $listings->first()->price);
    }

    public function test_listings_are_paginated()
    {
        Listing::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get(route('listings.index'));

        $response->assertOk();
        $listings = $response->viewData('listings');
        $this->assertEquals(12, $listings->count());
    }

    public function test_guest_cannot_access_create_listing_page()
    {
        $response = $this->get(route('listings.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_create_listing_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('listings.create'));

        $response->assertOk();
        $response->assertViewIs('listings.create');
        $response->assertViewHas('schools');
        $response->assertViewHas('categories');
    }

    public function test_authenticated_user_can_create_listing_with_photos()
    {
        Storage::fake('public');

        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
            'photos' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg'),
            ]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertRedirect(route('listings.index'));
        $response->assertSessionHas('success');

        $listing = Listing::where('title', 'Test Listing')->first();
        $this->assertCount(2, $listing->photos);

        Storage::disk('public')->assertExists($listing->photos->first()->photo);
    }

    public function test_photos_are_required_when_creating_listing()
    {
        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertSessionHasErrors('photos');
    }

    public function test_can_upload_up_to_10_photos()
    {
        Storage::fake('public');

        $photos = [];
        for ($i = 0; $i < 10; $i++) {
            $photos[] = UploadedFile::fake()->image("photo{$i}.jpg");
        }

        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
            'photos' => $photos
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertRedirect(route('listings.index'));
        
        $listing = Listing::latest()->first();
        $this->assertCount(10, $listing->photos);
    }

    public function test_cannot_upload_more_than_10_photos()
    {
        Storage::fake('public');

        $photos = [];
        for ($i = 0; $i < 11; $i++) {
            $photos[] = UploadedFile::fake()->image("photo{$i}.jpg");
        }

        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
            'photos' => $photos
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertSessionHasErrors('photos');
    }

    public function test_photos_must_be_images()
    {
        Storage::fake('public');

        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
            'photos' => [
                UploadedFile::fake()->create('document.pdf', 100)
            ]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertSessionHasErrors('photos.0');
    }

    public function test_photos_must_not_exceed_8mb()
    {
        Storage::fake('public');

        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
            'photos' => [
                UploadedFile::fake()->image('large.jpg')->size(8193)
            ]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), $listingData);

        $response->assertSessionHasErrors('photos.0');
    }

    public function test_guest_cannot_create_listing()
    {
        $listingData = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $this->school->id,
            'category_id' => $this->category->id,
        ];

        $response = $this->post(route('listings.store'), $listingData);

        $response->assertRedirect(route('login'));
    }

    public function test_listing_requires_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('listings.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'price', 'school_id', 'category_id']);
    }

    public function test_guest_cannot_view_listing_details()
    {
        $listing = Listing::factory()->create([
            'school_id' => $this->school->id
        ]);

        $response = $this->get(route('listings.show', $listing));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_listing_details()
    {
        $listing = Listing::factory()->create([
            'school_id' => $this->school->id
        ]);

        $response = $this->actingAs($this->user)->get(route('listings.show', $listing));

        $response->assertOk();
        $response->assertViewIs('listings.show');
        $response->assertSee($listing->title);
        $response->assertSee($listing->description);
    }

    public function test_authenticated_user_can_view_their_listings()
    {
        $userListing = Listing::factory()->create(['user_id' => $this->user->id]);
        $otherListing = Listing::factory()->create(['user_id' => User::factory()->create()->id]);

        $response = $this->actingAs($this->user)
            ->get(route('listings.my'));

        $response->assertOk();
        $response->assertViewIs('listings.user.index');
        $response->assertSee($userListing->title);
        $response->assertDontSee($otherListing->title);
    }

    public function test_guest_cannot_view_my_listings()
    {
        $response = $this->get(route('listings.my'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_delete_their_own_listing()
    {
        $listing = Listing::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('listings.destroy', $listing));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertSoftDeleted('listings', ['id' => $listing->id]);
    }

    public function test_user_cannot_delete_another_users_listing()
    {
        $otherUser = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('listings.destroy', $listing));

        $response->assertForbidden();
        $this->assertDatabaseHas('listings', ['id' => $listing->id]);
    }

    public function test_guest_cannot_delete_listing()
    {
        $listing = Listing::factory()->create();

        $response = $this->delete(route('listings.destroy', $listing));

        $response->assertRedirect(route('login'));
    }
}

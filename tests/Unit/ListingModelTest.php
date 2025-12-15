<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Listing;
use App\Models\User;
use App\Models\School;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function listing_belongs_to_user()
    {
        $listing = Listing::factory()->create();

        $this->assertInstanceOf(User::class, $listing->user);
    }

    /** @test */
    public function listing_belongs_to_school()
    {
        $listing = Listing::factory()->create();

        $this->assertInstanceOf(School::class, $listing->school);
    }

    /** @test */
    public function listing_belongs_to_category()
    {
        $listing = Listing::factory()->create();

        $this->assertInstanceOf(Category::class, $listing->category);
    }

    /** @test */
    public function listing_can_have_many_photos()
    {
        $listing = Listing::factory()->create();
        
        $listing->photos()->create(['photo' => 'test.jpg']);
        $listing->photos()->create(['photo' => 'test2.jpg']);

        $this->assertCount(2, $listing->photos);
    }

    /** @test */
    public function listing_filter_by_region_works()
    {
        $school1 = School::factory()->create(['region' => 'Rīga']);
        $school2 = School::factory()->create(['region' => 'Daugavpils']);
        
        $listing1 = Listing::factory()->create(['school_id' => $school1->id]);
        $listing2 = Listing::factory()->create(['school_id' => $school2->id]);

        $filtered = Listing::filter(['region' => 'Rīga'])->get();

        $this->assertTrue($filtered->contains($listing1));
        $this->assertFalse($filtered->contains($listing2));
    }

    /** @test */
    public function listing_filter_by_school_works()
    {
        $school1 = School::factory()->create();
        $school2 = School::factory()->create();
        
        $listing1 = Listing::factory()->create(['school_id' => $school1->id]);
        $listing2 = Listing::factory()->create(['school_id' => $school2->id]);

        $filtered = Listing::filter(['school' => $school1->id])->get();

        $this->assertTrue($filtered->contains($listing1));
        $this->assertFalse($filtered->contains($listing2));
    }

    /** @test */
    public function listing_filter_by_category_works()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        
        $listing1 = Listing::factory()->create(['category_id' => $category1->id]);
        $listing2 = Listing::factory()->create(['category_id' => $category2->id]);

        $filtered = Listing::filter(['category' => $category1->id])->get();

        $this->assertTrue($filtered->contains($listing1));
        $this->assertFalse($filtered->contains($listing2));
    }
}
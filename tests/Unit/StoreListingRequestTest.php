<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\School;
use App\Models\Category;
use App\Http\Requests\StoreListingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class StoreListingRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function title_is_required()
    {
        $request = new StoreListingRequest();
        $validator = Validator::make(['title' => ''], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
    }

    /** @test */
    public function description_is_required()
    {
        $request = new StoreListingRequest();
        $validator = Validator::make(['description' => ''], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('description', $validator->errors()->toArray());
    }

    /** @test */
    public function price_is_required_and_must_be_numeric()
    {
        $request = new StoreListingRequest();
        
        $validator = Validator::make(['price' => ''], $request->rules());
        $this->assertTrue($validator->fails());
        
        $validator = Validator::make(['price' => 'abc'], $request->rules());
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function price_must_be_minimum_zero()
    {
        $request = new StoreListingRequest();
        $validator = Validator::make(['price' => -5], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    /** @test */
    public function school_id_is_required_and_must_exist()
    {
        $request = new StoreListingRequest();
        
        $validator = Validator::make(['school_id' => ''], $request->rules());
        $this->assertTrue($validator->fails());
        
        $validator = Validator::make(['school_id' => 99999], $request->rules());
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function category_id_is_required_and_must_exist()
    {
        $request = new StoreListingRequest();
        
        $validator = Validator::make(['category_id' => ''], $request->rules());
        $this->assertTrue($validator->fails());
        
        $validator = Validator::make(['category_id' => 99999], $request->rules());
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function photos_are_required()
    {
        $request = new StoreListingRequest();
        $validator = Validator::make(['photos' => []], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('photos', $validator->errors()->toArray());
    }

    /** @test */
    public function photos_must_be_array()
    {
        $request = new StoreListingRequest();
        $validator = Validator::make(['photos' => 'not-an-array'], $request->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function can_have_maximum_10_photos()
    {
        $request = new StoreListingRequest();
        
        $photos = array_fill(0, 11, 'photo.jpg');
        $validator = Validator::make(['photos' => $photos], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('photos', $validator->errors()->toArray());
    }

    /** @test */
    public function valid_data_passes_validation()
    {
        $school = School::factory()->create();
        $category = Category::factory()->create();
        
        $request = new StoreListingRequest();
        
        $data = [
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 25.50,
            'school_id' => $school->id,
            'category_id' => $category->id,
            'photos' => ['photo1.jpg', 'photo2.jpg']
        ];
        
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }
}
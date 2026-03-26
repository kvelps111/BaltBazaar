<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Models\Report;
use App\Models\BannedUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

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
    }

    // ── Access control — index ─────────────────────────────────────────

    public function test_guest_cannot_access_admin_users_index()
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_users_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_users_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    // ── Index content ─────────────────────────────────────────────────

    public function test_admin_users_index_shows_all_users()
    {
        $extra = User::factory()->create([
            'name'              => 'Jānis Bērziņš',
            'phone_verified_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $response->assertSee('Jānis Bērziņš');
    }

    public function test_admin_users_index_is_paginated_at_20()
    {
        User::factory()->count(25)->create(['phone_verified_at' => now()]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $this->assertEquals(20, $response->viewData('users')->count());
    }

    public function test_users_index_includes_listings_count()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();

        Listing::factory()->count(3)->create([
            'user_id'     => $this->user->id,
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $users    = $response->viewData('users');
        $viewUser = $users->firstWhere('id', $this->user->id);
        $this->assertEquals(3, $viewUser->listings_count);
    }

    // ── Show user ──────────────────────────────────────────────────────

    public function test_guest_cannot_view_user_detail()
    {
        $response = $this->get(route('admin.users.show', $this->user));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_view_user_detail()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.show', $this->user));

        $response->assertForbidden();
    }

    public function test_admin_can_view_user_detail()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));

        $response->assertOk();
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user');
    }

    public function test_user_detail_shows_user_information()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));

        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    public function test_user_detail_loads_listings_and_reports_relations()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));

        $viewUser = $response->viewData('user');
        $this->assertTrue($viewUser->relationLoaded('listings'));
        $this->assertTrue($viewUser->relationLoaded('reports'));
    }

    public function test_user_detail_shows_users_listings()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();

        $listing = Listing::factory()->create([
            'user_id'     => $this->user->id,
            'school_id'   => $school->id,
            'category_id' => $category->id,
            'title'       => 'My Special Listing',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));

        $response->assertSee('My Special Listing');
    }

    public function test_user_detail_shows_users_reports()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        $listing  = Listing::factory()->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        Report::factory()->create([
            'user_id'    => $this->user->id,
            'listing_id' => $listing->id,
            'reason'     => 'Krāpšana',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));

        $response->assertSee('Krāpšana');
    }

    // ── Ban user ───────────────────────────────────────────────────────

    public function test_guest_cannot_ban_a_user()
    {
        $response = $this->post(route('admin.users.ban', $this->user), [
            'reason' => 'Spam',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('banned_users', ['email' => $this->user->email]);
    }

    public function test_regular_user_cannot_ban_another_user()
    {
        $target = User::factory()->create(['phone_verified_at' => now()]);

        $response = $this->actingAs($this->user)
            ->post(route('admin.users.ban', $target), ['reason' => 'Spam']);

        $response->assertForbidden();
        $this->assertDatabaseMissing('banned_users', ['email' => $target->email]);
    }

    public function test_admin_can_ban_a_regular_user()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Spam']);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('banned_users', [
            'email'  => $this->user->email,
            'reason' => 'Spam',
        ]);
    }

    public function test_banning_a_user_stores_phone_number_in_banned_table()
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Fraud']);

        $this->assertDatabaseHas('banned_users', [
            'phone_number' => $this->user->phone_number,
        ]);
    }

    public function test_banning_a_user_deletes_their_account()
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Spam']);

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function test_banning_a_user_soft_deletes_their_listings()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();

        $listing = Listing::factory()->create([
            'user_id'     => $this->user->id,
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Spam']);

        $this->assertSoftDeleted('listings', ['id' => $listing->id]);
    }

    public function test_banning_records_which_admin_performed_the_ban()
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Fraud']);

        $this->assertDatabaseHas('banned_users', [
            'banned_by' => $this->admin->id,
        ]);
    }

    public function test_admin_cannot_ban_another_admin()
    {
        $anotherAdmin = User::factory()->create([
            'is_admin'          => true,
            'phone_verified_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $anotherAdmin), ['reason' => 'Spam']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('banned_users', ['email' => $anotherAdmin->email]);
    }

    public function test_admin_cannot_ban_an_already_banned_user()
    {
        // First ban
        BannedUser::create([
            'user_id'      => $this->user->id,
            'email'        => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'reason'       => 'First Reason',
            'banned_by'    => $this->admin->id,
        ]);

        // Attempt second ban
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => 'Second Reason']);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertEquals(1, BannedUser::where('email', $this->user->email)->count());
    }

    public function test_ban_requires_reason_field()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), ['reason' => '']);

        $response->assertSessionHasErrors('reason');
        $this->assertDatabaseMissing('banned_users', ['email' => $this->user->email]);
    }

    public function test_ban_reason_cannot_exceed_255_characters()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), [
                'reason' => str_repeat('a', 256),
            ]);

        $response->assertSessionHasErrors('reason');
    }

    public function test_ban_optional_notes_field_is_stored()
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), [
                'reason' => 'Spam',
                'notes'  => 'Repeatedly posted duplicates.',
            ]);

        $this->assertDatabaseHas('banned_users', [
            'email' => $this->user->email,
            'notes' => 'Repeatedly posted duplicates.',
        ]);
    }

    public function test_ban_optional_notes_can_be_null()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->user), [
                'reason' => 'Spam',
            ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('banned_users', [
            'email' => $this->user->email,
            'notes' => null,
        ]);
    }

    public function test_banned_user_cannot_register_with_same_email()
    {
        BannedUser::create([
            'user_id'      => $this->user->id,
            'phone_number' => $this->user->phone_number,
            'email'        => $this->user->email,
            'reason'       => 'Spam',
            'banned_by'    => $this->admin->id,
        ]);

        $response = $this->post(route('register'), [
            'name'                  => 'New Person',
            'email'                 => $this->user->email,
            'phone_number'          => '12345678',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_banned_user_cannot_register_with_same_phone()
    {
        // UserFactory generates '+371########' — strip the '+371' prefix
        $rawPhone = substr($this->user->phone_number, 4); // remove '+371'

        BannedUser::create([
            'user_id'      => $this->user->id,
            'phone_number' => $this->user->phone_number,
            'email'        => $this->user->email,
            'reason'       => 'Spam',
            'banned_by'    => $this->admin->id,
        ]);

        $response = $this->post(route('register'), [
            'name'                  => 'New Person',
            'email'                 => 'completely-new@example.com',
            'phone_number'          => $rawPhone,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('phone_number');
    }
}
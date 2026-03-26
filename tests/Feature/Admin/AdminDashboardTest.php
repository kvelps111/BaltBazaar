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

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'phone_verified_at' => now(),
        ]);

        $this->user = User::factory()->create([
            'is_admin' => false,
            'phone_verified_at' => now(),
        ]);
    }

    // ── Access control ────────────────────────────────────────────────

    public function test_guest_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
    }

    // ── Stats ─────────────────────────────────────────────────────────

    public function test_dashboard_shows_correct_total_user_count()
    {
        User::factory()->count(4)->create(['phone_verified_at' => now()]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $stats = $response->viewData('stats');
        // 4 created + admin + regular user from setUp = 6
        $this->assertEquals(6, $stats['total_users']);
    }

    public function test_dashboard_shows_correct_total_listing_count()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        Listing::factory()->count(5)->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $stats = $response->viewData('stats');
        $this->assertEquals(5, $stats['total_listings']);
    }

    public function test_dashboard_shows_correct_pending_report_count()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        $listing  = Listing::factory()->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        Report::factory()->count(3)->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'pending',
        ]);
        Report::factory()->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'resolved',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $stats = $response->viewData('stats');
        $this->assertEquals(3, $stats['pending_reports']);
        $this->assertEquals(4, $stats['total_reports']);
    }

    public function test_dashboard_shows_correct_banned_user_count()
    {
        BannedUser::factory()->count(2)->create([
            'banned_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $stats = $response->viewData('stats');
        $this->assertEquals(2, $stats['banned_users']);
    }

    public function test_dashboard_passes_recent_reports_to_view()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        $listing  = Listing::factory()->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        Report::factory()->count(3)->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertViewHas('recentReports');
        $this->assertCount(3, $response->viewData('recentReports'));
    }

    public function test_dashboard_recent_reports_capped_at_five()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        $listing  = Listing::factory()->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        Report::factory()->count(8)->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $this->assertCount(5, $response->viewData('recentReports'));
    }

    public function test_dashboard_recent_reports_only_shows_pending()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        $listing  = Listing::factory()->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        Report::factory()->count(2)->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'pending',
        ]);
        Report::factory()->create([
            'listing_id' => $listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'resolved',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $recentReports = $response->viewData('recentReports');
        $this->assertCount(2, $recentReports);
        foreach ($recentReports as $report) {
            $this->assertEquals('pending', $report->status);
        }
    }

    public function test_dashboard_passes_recent_listings_to_view()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        Listing::factory()->count(3)->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertViewHas('recentListings');
        $this->assertCount(3, $response->viewData('recentListings'));
    }

    public function test_dashboard_recent_listings_capped_at_five()
    {
        $school   = School::factory()->create();
        $category = Category::factory()->create();
        Listing::factory()->count(10)->create([
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $this->assertCount(5, $response->viewData('recentListings'));
    }

    public function test_dashboard_active_users_counts_last_30_days()
    {
        // Created more than 30 days ago — should NOT be counted
        User::factory()->create([
            'phone_verified_at' => now(),
            'created_at'        => now()->subDays(31),
        ]);

        // Created within last 30 days
        User::factory()->count(2)->create([
            'phone_verified_at' => now(),
            'created_at'        => now()->subDays(5),
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $stats = $response->viewData('stats');
        // admin (setUp, now) + user (setUp, now) + 2 new = 4 within 30 days
        $this->assertEquals(4, $stats['active_users']);
    }
}
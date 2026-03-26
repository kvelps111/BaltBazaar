<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use App\Models\School;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected Listing $listing;

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

        $school   = School::factory()->create();
        $category = Category::factory()->create();

        $this->listing = Listing::factory()->create([
            'user_id'     => $this->user->id,
            'school_id'   => $school->id,
            'category_id' => $category->id,
        ]);
    }

    private function makeReport(array $overrides = []): Report
    {
        return Report::factory()->create(array_merge([
            'listing_id' => $this->listing->id,
            'user_id'    => $this->user->id,
            'status'     => 'pending',
        ], $overrides));
    }

    // ── Access control — index ─────────────────────────────────────────

    public function test_guest_cannot_access_admin_reports_index()
    {
        $response = $this->get(route('admin.reports.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_reports_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.reports.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_reports_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.index'));

        $response->assertOk();
        $response->assertViewIs('admin.reports.index');
        $response->assertViewHas('reports');
    }

    // ── Index content ─────────────────────────────────────────────────

    public function test_admin_reports_index_shows_all_reports()
    {
        $report1 = $this->makeReport(['reason' => 'Krāpšana']);
        $report2 = $this->makeReport(['reason' => 'Neatbilstošs saturs', 'status' => 'resolved']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.index'));

        $response->assertSee('Krāpšana');
        $response->assertSee('Neatbilstošs saturs');
    }

    public function test_admin_reports_index_shows_reports_with_all_statuses()
    {
        $statuses = ['pending', 'reviewed', 'resolved', 'dismissed'];

        foreach ($statuses as $status) {
            $this->makeReport(['status' => $status]);
        }

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.index'));

        $reports = $response->viewData('reports');
        $this->assertCount(4, $reports);
    }

    public function test_admin_reports_index_is_paginated_at_20()
    {
        Report::factory()->count(25)->create([
            'listing_id' => $this->listing->id,
            'user_id'    => $this->user->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.index'));

        $this->assertEquals(20, $response->viewData('reports')->count());
    }

    // ── Show report ───────────────────────────────────────────────────

    public function test_guest_cannot_view_report_detail()
    {
        $report = $this->makeReport();

        $response = $this->get(route('admin.reports.show', $report));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_view_report_detail()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->user)
            ->get(route('admin.reports.show', $report));

        $response->assertForbidden();
    }

    public function test_admin_can_view_report_detail()
    {
        $report = $this->makeReport(['reason' => 'Dublikāts']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.show', $report));

        $response->assertOk();
        $response->assertViewIs('admin.reports.show');
        $response->assertSee('Dublikāts');
    }

    public function test_report_detail_loads_listing_and_user_relations()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.show', $report));

        $viewReport = $response->viewData('report');
        $this->assertTrue($viewReport->relationLoaded('listing'));
        $this->assertTrue($viewReport->relationLoaded('user'));
    }

    // ── Update report status ──────────────────────────────────────────

    public function test_guest_cannot_update_report_status()
    {
        $report = $this->makeReport();

        $response = $this->patch(route('admin.reports.update', $report), [
            'status' => 'resolved',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_update_report_status()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->user)
            ->patch(route('admin.reports.update', $report), [
                'status' => 'resolved',
            ]);

        $response->assertForbidden();
    }

    public function test_admin_can_update_report_status_to_reviewed()
    {
        $report = $this->makeReport(['status' => 'pending']);

        $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'reviewed']);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => 'reviewed',
        ]);
    }

    public function test_admin_can_update_report_status_to_resolved()
    {
        $report = $this->makeReport(['status' => 'pending']);

        $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'resolved']);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => 'resolved',
        ]);
    }

    public function test_admin_can_update_report_status_to_dismissed()
    {
        $report = $this->makeReport(['status' => 'pending']);

        $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'dismissed']);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => 'dismissed',
        ]);
    }

    public function test_report_status_update_rejects_invalid_status()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'nonexistent']);

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => 'pending',
        ]);
    }

    public function test_report_status_update_requires_status_field()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), []);

        $response->assertSessionHasErrors('status');
    }

    public function test_admin_is_redirected_back_after_status_update()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'resolved']);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    // ── Delete report ─────────────────────────────────────────────────

    public function test_guest_cannot_delete_report()
    {
        $report = $this->makeReport();

        $response = $this->delete(route('admin.reports.destroy', $report));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('reports', ['id' => $report->id]);
    }

    public function test_regular_user_cannot_delete_report()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.reports.destroy', $report));

        $response->assertForbidden();
        $this->assertDatabaseHas('reports', ['id' => $report->id]);
    }

    public function test_admin_can_delete_report()
    {
        $report = $this->makeReport();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.reports.destroy', $report));

        $response->assertRedirect(route('admin.reports.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('reports', ['id' => $report->id]);
    }

    public function test_deleting_report_does_not_delete_the_listing()
    {
        $report = $this->makeReport();

        $this->actingAs($this->admin)
            ->delete(route('admin.reports.destroy', $report));

        $this->assertDatabaseHas('listings', ['id' => $this->listing->id]);
    }

    // ── Report with deleted listing ───────────────────────────────────

    public function test_admin_can_view_report_where_listing_was_deleted()
    {
        $report = $this->makeReport();
        $this->listing->delete();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.reports.show', $report));

        $response->assertOk();
        // View should handle null listing gracefully
        $response->assertSee('Listing Deleted');
    }

    public function test_admin_can_still_update_status_when_listing_deleted()
    {
        $report = $this->makeReport();
        $this->listing->delete();

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.reports.update', $report), ['status' => 'dismissed']);

        $this->assertDatabaseHas('reports', [
            'id'     => $report->id,
            'status' => 'dismissed',
        ]);
    }
}
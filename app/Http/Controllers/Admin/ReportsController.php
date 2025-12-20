<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $reports = Report::with(['listing', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['listing.user', 'user']);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
        ]);

        $report->update($validated);

        return redirect()->back()->with('success', 'Report status updated successfully.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
    }
}

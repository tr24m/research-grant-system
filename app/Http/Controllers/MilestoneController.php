<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Grant;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index()
    {
        // Fetch milestones with associated grant
        $milestones = Milestone::with('grant')->get();
        return view('milestones.index', compact('milestones'));
    }

    public function create(Grant $grant)
    {
        // Pass the grant to the milestone creation view
        return view('milestones.create', compact('grant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grant_id' => 'required|exists:grants,id',
            'name' => 'required|string|max:255', // Updated field name for milestone
            'target_completion_date' => 'required|date',
            'deliverable' => 'required|string|max:255',
            'status' => 'required|in:Pending,Completed',
        ]);

        Milestone::create($request->all());

        return redirect()->route('leader.dashboard')->with('success', 'Milestone added successfully.');
    }

    public function edit(Milestone $milestone)
    {
        // Fetch all grants to allow reassignment
        $grants = Grant::all();
        return view('milestones.edit', compact('milestone', 'grants'));
    }

    public function update(Request $request, Milestone $milestone)
    {
        $request->validate([
            'grant_id' => 'required|exists:grants,id',
            'name' => 'required|string|max:255', // Updated field name for milestone
            'target_completion_date' => 'required|date',
            'deliverable' => 'required|string|max:255',
            'status' => 'required|in:Pending,Completed',
        ]);

        $milestone->update($request->all());

        return redirect()->route('leader.dashboard')->with('success', 'Milestone updated successfully.');
    }

    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect()->route('leader.dashboard')->with('success', 'Milestone deleted successfully.');
    }
}

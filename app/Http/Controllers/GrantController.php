<?php

namespace App\Http\Controllers;

use App\Models\Grant;
use App\Models\Academician;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index()
    {
        // Fetch all grants with associated leader and members
        $grants = Grant::with('leader', 'members')->get();
        return view('grants.index', compact('grants'));
    }

    public function create()
    {
        // Fetch all academicians for grant creation
        $academicians = Academician::all();
        return view('grants.create', compact('academicians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leader_id' => 'required|exists:users,id', // Ensure leader exists in users table
            'grant_provider' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
        ]);

        Grant::create($request->all());

        return redirect()->route('grants.index')->with('success', 'Grant created successfully.');
    }

    public function edit(Grant $grant)
    {
        // Fetch all academicians for editing
        $academicians = Academician::all();
        return view('grants.edit', compact('grant', 'academicians'));
    }

    public function update(Request $request, Grant $grant)
    {
        $request->validate([
            'leader_id' => 'required|exists:users,id', // Ensure leader exists in users table
            'grant_provider' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
        ]);

        $grant->update($request->all());

        return redirect()->route('grants.index')->with('success', 'Grant updated successfully.');
    }

    public function destroy(Grant $grant)
    {
        $grant->delete();

        return redirect()->route('grants.index')->with('success', 'Grant deleted successfully.');
    }

    public function academicDashboard()
    {
        // Fetch grants where the user is a member
        $grants = auth()->user()->grantsAsMember()->with('leader')->get();

        return view('academic.dashboard', compact('grants'));
    }

    public function leaderDashboard()
    {
        // Fetch all grants where the logged-in user is the leader
        $grants = Grant::where('leader_id', auth()->id())->get();

        return view('leader.dashboard', compact('grants'));
    }
}

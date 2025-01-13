@extends('layouts.app')

@section('title', 'Milestones for Grant')

@section('content')
<h1>Milestones for {{ $grant->project_title }}</h1>
<a href="{{ route('milestones.create', $grant->id) }}" class="btn btn-primary mb-3">Add Milestone</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Milestone Name</th>
            <th>Target Completion Date</th>
            <th>Deliverable</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grant->milestones as $milestone)
            <tr>
                <td>{{ $milestone->milestone_name }}</td>
                <td>{{ $milestone->target_completion_date }}</td>
                <td>{{ $milestone->deliverable }}</td>
                <td>{{ $milestone->status }}</td>
                <td>{{ $milestone->remarks }}</td>
                <td>
                    <a href="{{ route('milestones.edit', $milestone->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('milestones.destroy', $milestone->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

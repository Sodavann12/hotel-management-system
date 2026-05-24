<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousekeepingTask;
use App\Models\Room;
use App\Models\Staff;
use Illuminate\Http\Request;

class HousekeepingController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $tasks = HousekeepingTask::with(['room', 'staff.user'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.housekeeping.index', compact('tasks'));
    }

    public function create(): \Illuminate\View\View
    {
        $rooms = Room::orderBy('number')->get();
        $staff = Staff::with('user')->where('is_active', true)->get();
        return view('admin.housekeeping.create', compact('rooms', 'staff'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'room_id'      => ['required', 'exists:rooms,id'],
            'staff_id'     => ['nullable', 'exists:staff,id'],
            'type'         => ['required', 'in:cleaning,turndown,deep_clean,inspection'],
            'scheduled_at' => ['required', 'date'],
            'notes'        => ['nullable', 'string'],
        ]);

        $validated['status'] = 'pending';

        HousekeepingTask::create($validated);

        return redirect()
            ->route('admin.housekeeping.index')
            ->with('success', 'Housekeeping task created.');
    }

    public function show(HousekeepingTask $housekeeping): \Illuminate\View\View
    {
        return view('admin.housekeeping.show', compact('housekeeping'));
    }

    public function edit(HousekeepingTask $housekeeping): \Illuminate\View\View
    {
        $rooms = Room::orderBy('number')->get();
        $staff = Staff::with('user')->where('is_active', true)->get();
        return view('admin.housekeeping.edit', compact('housekeeping', 'rooms', 'staff'));
    }

    public function update(Request $request, HousekeepingTask $housekeeping): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed,skipped'],
            'notes'  => ['nullable', 'string'],
        ]);

        $housekeeping->update($validated);

        return redirect()
            ->route('admin.housekeeping.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(HousekeepingTask $housekeeping): \Illuminate\Http\RedirectResponse
    {
        $housekeeping->delete();
        return redirect()
            ->route('admin.housekeeping.index')
            ->with('success', 'Task deleted.');
    }
}
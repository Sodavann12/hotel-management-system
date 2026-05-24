<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $staff = Staff::with('user')->latest()->paginate(20);
        return view('admin.staff.index', compact('staff'));
    }

    public function create(): \Illuminate\View\View
    {
        $users = User::all();
        return view('admin.staff.create', compact('users'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'user_id'     => ['required', 'exists:users,id'],
            'employee_id' => ['required', 'string', 'unique:staff,employee_id'],
            'department'  => ['required', 'string'],
            'position'    => ['required', 'string'],
            'phone'       => ['nullable', 'string'],
            'shift'       => ['required', 'in:morning,afternoon,night,rotating'],
            'joined_at'   => ['required', 'date'],
        ]);

        $validated['is_active'] = true;

        Staff::create($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    public function show(Staff $staff): \Illuminate\View\View
    {
        $staff->load('user');
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff): \Illuminate\View\View
    {
        $users = User::all();
        return view('admin.staff.edit', compact('staff', 'users'));
    }

    public function update(Request $request, Staff $staff): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string'],
            'position'   => ['required', 'string'],
            'phone'      => ['nullable', 'string'],
            'shift'      => ['required', 'in:morning,afternoon,night,rotating'],
            'joined_at'  => ['required', 'date'],
            'is_active'  => ['required', 'in:0,1'],
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];

        $staff->update($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff): \Illuminate\Http\RedirectResponse
    {
        $staff->delete();
        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member removed.');
    }
}
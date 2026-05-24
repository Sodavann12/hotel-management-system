@extends('admin.layouts.app')

@section('title', 'Staff')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Staff</h2>
            <p class="text-sm text-gray-500">Manage hotel employees</p>
        </div>
        <a href="{{ route('admin.staff.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Staff
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Employee</th>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Department</th>
                    <th class="px-6 py-3 text-left">Position</th>
                    <th class="px-6 py-3 text-left">Shift</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($staff as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-purple-700 text-xs font-semibold">
                                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $member->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $member->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs">{{ $member->employee_id }}</td>
                        <td class="px-6 py-4">{{ $member->department }}</td>
                        <td class="px-6 py-4">{{ $member->position }}</td>
                        <td class="px-6 py-4">
                            <span class="capitalize">{{ $member->shift }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($member->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Active</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.staff.edit', $member) }}"
                                   class="text-blue-600 hover:text-blue-800 text-xs">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $member) }}"
                                      onsubmit="return confirm('Delete this staff member?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 text-xs">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-user-tie text-4xl mb-3 block"></i>
                            No staff members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('admin.layouts.app')

@section('title', 'Housekeeping')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Housekeeping Tasks</h2>
            <p class="text-sm text-gray-500">Manage room cleaning and maintenance</p>
        </div>
        <a href="{{ route('admin.housekeeping.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Task
        </a>
    </div>

    {{-- Status tabs --}}
    <div class="flex gap-2 mb-6">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
            <a href="{{ $value === 'all' ? route('admin.housekeeping.index') : route('admin.housekeeping.index', ['status' => $value]) }}"
               class="px-3 py-1.5 rounded-full text-xs font-medium border
               {{ request('status', 'all') === $value ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Room</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Assigned To</th>
                    <th class="px-6 py-3 text-left">Scheduled</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($tasks as $task)
                    @php
                        $colors = [
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                            'in_progress' => 'bg-blue-100 text-blue-700',
                            'completed'   => 'bg-green-100 text-green-700',
                            'skipped'     => 'bg-gray-100 text-gray-600',
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">Room {{ $task->room->number }}</td>
                        <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $task->type) }}</td>
                        <td class="px-6 py-4">
                            {{ $task->staff ? $task->staff->user->name : 'Unassigned' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $task->scheduled_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $colors[$task->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.housekeeping.destroy', $task) }}"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-broom text-4xl mb-3 block"></i>
                            No housekeeping tasks found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
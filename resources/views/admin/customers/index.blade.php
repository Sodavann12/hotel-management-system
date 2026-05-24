@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Customers</h2>
            <p class="text-sm text-gray-500">All registered guests</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email..."
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-72">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                <i class="fas fa-search mr-1"></i> Search
            </button>
            <a href="{{ route('admin.customers.index') }}"
               class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
                Clear
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Joined</th>
                    <th class="px-6 py-3 text-left">Total Bookings</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-400">{{ $customer->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-700 text-xs font-semibold">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $customer->email }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                {{ $customer->bookings_count }} bookings
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.customers.show', $customer) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 block"></i>
                            No customers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($customers->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $customers->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
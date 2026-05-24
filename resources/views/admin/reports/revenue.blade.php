
@extends('admin.layouts.app')

@section('title', 'Revenue Report')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Revenue Report</h2>
            <p class="text-sm text-gray-500">Financial overview for {{ now()->format('F Y') }}</p>
        </div>
    </div>

    {{-- Revenue Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Today's Revenue</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">
                ${{ number_format($revenue['today'], 2) }}
            </p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">This Month</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">
                ${{ number_format($revenue['this_month'], 2) }}
            </p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600 mt-1">
                ${{ number_format($revenue['total'], 2) }}
            </p>
        </div>
    </div>

    {{-- Booking Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Total Bookings</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $bookingStats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">This Month</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $bookingStats['this_month'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Cancelled</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $bookingStats['cancelled'] }}</p>
        </div>
    </div>

    {{-- Recent Paid Invoices --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Paid Invoices</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Invoice</th>
                    <th class="px-6 py-3 text-left">Guest</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentInvoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono text-xs">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-3">{{ $invoice->booking->user->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $invoice->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3 font-semibold text-green-600">
                            ${{ number_format($invoice->total, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            No paid invoices yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
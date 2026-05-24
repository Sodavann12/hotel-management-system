@extends('admin.layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Invoices</h2>
            <p class="text-sm text-gray-500">All billing records</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Invoice #</th>
                    <th class="px-6 py-3 text-left">Guest</th>
                    <th class="px-6 py-3 text-left">Booking</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Due Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($invoices as $invoice)
                    @php
                        $colors = [
                            'draft'          => 'bg-gray-100 text-gray-600',
                            'issued'         => 'bg-blue-100 text-blue-700',
                            'paid'           => 'bg-green-100 text-green-700',
                            'partially_paid' => 'bg-yellow-100 text-yellow-700',
                            'overdue'        => 'bg-red-100 text-red-700',
                            'cancelled'      => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-xs font-medium">
                            {{ $invoice->invoice_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $invoice->booking->user->name }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs">
                            {{ $invoice->booking->confirmation_code }}
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            ${{ number_format($invoice->total, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$invoice->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $invoice->due_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-file-invoice text-4xl mb-3 block"></i>
                            No invoices yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($invoices->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $invoices->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
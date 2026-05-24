@extends('admin.layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="mt-6 max-w-3xl">

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.invoices.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Invoices
        </a>
    </div>

    {{-- Invoice Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">INVOICE</h1>
                <p class="text-gray-500 font-mono mt-1">{{ $invoice->invoice_number }}</p>
            </div>
            @php
                $colors = [
                    'draft'          => 'bg-gray-100 text-gray-600',
                    'issued'         => 'bg-blue-100 text-blue-700',
                    'paid'           => 'bg-green-100 text-green-700',
                    'partially_paid' => 'bg-yellow-100 text-yellow-700',
                    'overdue'        => 'bg-red-100 text-red-700',
                    'cancelled'      => 'bg-gray-100 text-gray-600',
                ];
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-medium {{ $colors[$invoice->status] ?? 'bg-gray-100' }}">
                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
            </span>
        </div>

        {{-- Guest & Dates --}}
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Billed To</p>
                <p class="font-semibold text-gray-800">{{ $invoice->booking->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $invoice->booking->user->email }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 uppercase mb-1">Details</p>
                <p class="text-sm text-gray-700">Issue date: {{ $invoice->issue_date->format('d M Y') }}</p>
                <p class="text-sm text-gray-700">Due date: {{ $invoice->due_date->format('d M Y') }}</p>
                <p class="text-sm text-gray-700">
                    Booking: <span class="font-mono">{{ $invoice->booking->confirmation_code }}</span>
                </p>
            </div>
        </div>

        {{-- Line Items --}}
        <div class="border border-gray-100 rounded-lg overflow-hidden mb-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-right text-xs text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">
                                Room {{ $invoice->booking->room->number }} — {{ $invoice->booking->room->roomType->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $invoice->booking->check_in->format('d M Y') }} →
                                {{ $invoice->booking->check_out->format('d M Y') }}
                                ({{ $invoice->booking->nights }} nights)
                            </p>
                        </td>
                        <td class="px-4 py-3 text-right font-medium">
                            ${{ number_format($invoice->subtotal, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="flex justify-end">
            <div class="w-64 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span>${{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Tax ({{ $invoice->tax_rate }}%)</span>
                    <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                @if($invoice->discount > 0)
                    <div class="flex justify-between text-sm text-green-600">
                        <span>Discount</span>
                        <span>-${{ number_format($invoice->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-bold border-t border-gray-200 pt-2">
                    <span>Total</span>
                    <span>${{ number_format($invoice->total, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-green-600">
                    <span>Amount Paid</span>
                    <span>${{ number_format($invoice->amountPaid(), 2) }}</span>
                </div>
                @if($invoice->amountDue() > 0)
                    <div class="flex justify-between text-sm font-semibold text-red-600 border-t border-gray-100 pt-2">
                        <span>Amount Due</span>
                        <span>${{ number_format($invoice->amountDue(), 2) }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Payment Form --}}
        @if($invoice->amountDue() > 0)
            <div class="mt-8 border-t border-gray-100 pt-6">
                <h3 class="font-semibold text-gray-800 mb-4">Record Payment</h3>
                <form method="POST" action="{{ route('admin.payments.store', $invoice) }}"
                      class="flex flex-wrap gap-3 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Amount</label>
                        <input type="number" name="amount" step="0.01"
                               value="{{ $invoice->amountDue() }}"
                               class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-36">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Method</label>
                        <select name="method"
                                class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                        <i class="fas fa-check mr-1"></i> Record Payment
                    </button>
                </form>
            </div>
        @endif

        {{-- Payment History --}}
        @if($invoice->payments->count() > 0)
            <div class="mt-6 border-t border-gray-100 pt-6">
                <h3 class="font-semibold text-gray-800 mb-4">Payment History</h3>
                <div class="space-y-2">
                    @foreach($invoice->payments as $payment)
                        <div class="flex items-center justify-between text-sm p-3 bg-gray-50 rounded-lg">
                            <div>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span>
                                <span class="text-gray-400 text-xs ml-2">{{ $payment->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <span class="font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
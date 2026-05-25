{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 flex items-center gap-1">
                    <i class="fas fa-door-open text-green-400 text-xs"></i> Available Rooms
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['available_rooms'] }}</p>
                <p class="text-xs text-gray-400 mt-1">of {{ $stats['total_rooms'] }} total</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-door-open text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-3 h-1 bg-gray-100 rounded-full">
            <div class="h-1 bg-green-400 rounded-full"
                 style="width: {{ $stats['total_rooms'] > 0 ? ($stats['available_rooms'] / $stats['total_rooms']) * 100 : 0 }}%">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 flex items-center gap-1">
                    <i class="fas fa-calendar-check text-blue-400 text-xs"></i> Active Bookings
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['active_bookings'] }}</p>
                <p class="text-xs text-gray-400 mt-1">confirmed + checked in</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 flex items-center gap-1">
                    <i class="fas fa-plane-arrival text-purple-400 text-xs"></i> Today's Arrivals
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['today_arrivals'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->format('d M Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-plane-arrival text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 flex items-center gap-1">
                    <i class="fas fa-dollar-sign text-yellow-400 text-xs"></i> Monthly Revenue
                </p>
                <p class="text-3xl font-bold text-gray-800 mt-1">${{ number_format($stats['revenue_this_month'], 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

</div>
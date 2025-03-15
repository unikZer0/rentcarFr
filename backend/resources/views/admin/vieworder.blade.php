@extends('adminlte::page')

@section('title', 'Order Management')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Order Management</h1>
        <div class="flex space-x-2">
            <button onclick="showFilters()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter Orders
            </button>
        </div>
    </div>
@stop

@section('content')
    <!-- Filter Panel (Hidden by default) -->
    <div id="filterPanel" class="bg-white rounded-xl shadow-lg p-6 mb-6 hidden">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Filter Orders</h2>
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <div class="flex space-x-2">
                    <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="self-center">to</span>
                    <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">All Statuses</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Car Type</label>
                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">All Car Types</option>
                    @foreach(\App\Models\tbl_cars_types::all() as $type)
                        <option value="{{ $type->car_type_id }}">{{ $type->car_type_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 flex justify-end">
                <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors duration-300 mr-2">Reset</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">Apply Filters</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Book ID</th>
                        <th class="py-3 px-4 text-left">Customer</th>
                        <th class="py-3 px-4 text-left">Contact</th>
                        <th class="py-3 px-4 text-left">Car</th>
                        <th class="py-3 px-4 text-left">Location</th>
                        <th class="py-3 px-4 text-left">Pickup</th>
                        <th class="py-3 px-4 text-left">Dropoff</th>
                        <th class="py-3 px-4 text-left">Duration</th>
                        <th class="py-3 px-4 text-left">Total Price</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orderdata as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $order->booking->book_id }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 mr-2">
                                        @if($order->booking->customer->image)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset($order->booking->customer->image) }}" alt="{{ $order->booking->customer->first_name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                {{ substr($order->booking->customer->first_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-500">{{ $order->booking->customer->phone_number }}</div>
                                <div class="text-sm text-gray-500">{{ $order->booking->customer->email }}</div>
                            </td>
                            <td class="py-3 px-4">{{ $order->booking->car->car_name }}</td>
                            <td class="py-3 px-4">{{ $order->booking->Location }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->booking->Pickup)->format('M d, Y') }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->booking->dropoof)->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $start = \Carbon\Carbon::parse($order->booking->start);
                                    $end = \Carbon\Carbon::parse($order->booking->end);
                                    $days = $start->diffInDays($end) + 1;
                                @endphp
                                {{ $days }} days
                            </td>
                            <td class="py-3 px-4 font-medium text-green-600">{{ number_format($order->total, 0) }} KIP</td>
                            <td class="py-3 px-4">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $pickupDate = \Carbon\Carbon::parse($order->booking->Pickup);
                                    $dropoffDate = \Carbon\Carbon::parse($order->booking->dropoof);
                                    
                                    if ($now->lt($pickupDate)) {
                                        $status = 'Upcoming';
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($now->gt($dropoffDate)) {
                                        $status = 'Completed';
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } else {
                                        $status = 'Active';
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {!! $orderdata->links('pagination::tailwind') !!}
        </div>
    </div>
@stop

@section('js')
    <script>
        function showFilters() {
            const filterPanel = document.getElementById('filterPanel');
            filterPanel.classList.toggle('hidden');
        }
        
        function exportOrders() {
            alert('Export functionality will be implemented here');
            // Implement export to CSV/Excel functionality
        }
        
        console.log("Order management page loaded.");
    </script>
@stop

@section('css')
    <!-- No custom CSS needed as we're using Tailwind -->
@stop

@extends('adminlte::page')

@section('title', 'Manager Dashboard')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manager Dashboard</h1>
        <div class="flex space-x-3">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center" onclick="window.location.href='{{ route('manager.viewcar') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Car
            </button>
            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center" onclick="window.location.href='{{ route('manager.vieworder') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                View All Orders
            </button>
        </div>
    </div>
@stop

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders Card -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium opacity-80">Total Orders</p>
                        <h3 class="text-3xl font-bold mt-1">{{$orderCount}}</h3>
                    </div>
                    <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('manager.vieworder') }}" class="text-white text-sm font-medium hover:underline flex items-center">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Income Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium opacity-80">Monthly Income</p>
                        @if ($salesPerMonth->isEmpty())
                            <h3 class="text-3xl font-bold mt-1">0 KIP</h3>
                        @else
                            @foreach($salesPerMonth as $sales)
                                <p class="text-xs font-medium mt-1">{{ \Carbon\Carbon::createFromDate($sales->year, $sales->month, 1)->format('F Y') }}</p>
                                <h3 class="text-3xl font-bold mt-1">{{ number_format($sales->total_sales, 0) }} KIP</h3>
                            @endforeach
                        @endif
                    </div>
                    <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-white text-sm font-medium hover:underline flex items-center">
                        View Report
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Yearly Income Card -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium opacity-80">Yearly Income</p>
                        @if ($salesPerYear->isEmpty())
                            <h3 class="text-3xl font-bold mt-1">0 KIP</h3>
                        @else
                            @foreach ($salesPerYear as $item)
                                <p class="text-xs font-medium mt-1">{{ $item->year }}</p>
                                <h3 class="text-3xl font-bold mt-1">{{ number_format($item->total_sales, 0) }} KIP</h3>
                            @endforeach
                        @endif
                    </div>
                    <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-white text-sm font-medium hover:underline flex items-center">
                        View Report
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Available Cars Card -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium opacity-80">Available Cars</p>
                        <h3 class="text-3xl font-bold mt-1">{{ isset($availableCars) ? $availableCars : '?' }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('manager.viewcar') }}" class="text-white text-sm font-medium hover:underline flex items-center">
                        Manage Cars
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Calendar Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-1">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('manager.viewcar') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Add New Car</h3>
                        <p class="text-sm text-gray-500">Add a new car to the fleet</p>
                    </div>
                </a>
                <a href="{{ route('manager.vieworder') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">View Orders</h3>
                        <p class="text-sm text-gray-500">Check all customer orders</p>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Edit Profile</h3>
                        <p class="text-sm text-gray-500">Update your account details</p>
                    </div>
                </a>
                <a href="#" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Generate Report</h3>
                        <p class="text-sm text-gray-500">Create sales and inventory reports</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Calendar and Upcoming Bookings -->
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Upcoming Bookings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orderdata->take(5) as $order)
                            @php
                                $pickupDate = \Carbon\Carbon::parse($order->booking->start);
                                $today = \Carbon\Carbon::now();
                                $status = 'Upcoming';
                                $statusClass = 'bg-blue-100 text-blue-800';
                                
                                if ($pickupDate->isPast()) {
                                    $status = 'In Progress';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    
                                    if (\Carbon\Carbon::parse($order->booking->end)->isPast()) {
                                        $status = 'Completed';
                                        $statusClass = 'bg-green-100 text-green-800';
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->booking->start)->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->booking->start)->format('h:i A') }}</div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ substr($order->booking->customer->first_name, 0, 1) }}{{ substr($order->booking->customer->last_name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->booking->customer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->booking->car->car_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->booking->Location }}</div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Recent Orders</h2>
            <a href="{{ route('manager.vieworder') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Book ID</th>
                        <th class="py-3 px-4 text-left">Customer</th>
                        <th class="py-3 px-4 text-left">Car</th>
                        <th class="py-3 px-4 text-left">Location</th>
                        <th class="py-3 px-4 text-left">Pickup</th>
                        <th class="py-3 px-4 text-left">Dropoff</th>
                        <th class="py-3 px-4 text-left">Total Price</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orderdata as $order)
                        @php
                            $pickupDate = \Carbon\Carbon::parse($order->booking->start);
                            $dropoffDate = \Carbon\Carbon::parse($order->booking->end);
                            $today = \Carbon\Carbon::now();
                            
                            $status = 'Upcoming';
                            $statusClass = 'bg-blue-100 text-blue-800';
                            
                            if ($pickupDate->isPast() && $dropoffDate->isFuture()) {
                                $status = 'In Progress';
                                $statusClass = 'bg-yellow-100 text-yellow-800';
                            } elseif ($dropoffDate->isPast()) {
                                $status = 'Completed';
                                $statusClass = 'bg-green-100 text-green-800';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $order->booking->book_id }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr($order->booking->customer->first_name, 0, 1) }}{{ substr($order->booking->customer->last_name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">{{ $order->booking->car->car_name }}</td>
                            <td class="py-3 px-4">{{ $order->booking->Location }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->booking->start)->format('M d, Y') }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($order->booking->end)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 font-medium text-green-600">{{ number_format($order->total, 0) }} KIP</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $status }}
                                </span>
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

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles to enhance the dashboard */
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Ensure pagination looks good with Tailwind */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }
        
        .pagination .page-item {
            margin: 0 0.25rem;
        }
        
        .pagination .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            color: #3b82f6;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        
        .pagination .page-link:hover {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log("Manager dashboard loaded");
        
        // Add any additional JavaScript for interactive elements here
        document.addEventListener('DOMContentLoaded', function() {
            // You can add chart initializations or other interactive elements here
        });
    </script>
@stop

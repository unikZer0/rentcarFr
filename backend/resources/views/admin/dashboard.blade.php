@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
        
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-xl overflow-hidden transition-transform duration-300 hover:-translate-y-1">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-lg">Total Orders</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">{{$orderCount}}</h2>
                <p class="text-white text-opacity-80 text-sm">
                    @php
                        // Use booking created_at instead of order created_at since order doesn't have timestamps
                        $lastMonthOrders = \App\Models\Order::join('booking', 'order.book_id', '=', 'booking.book_id')
                            ->whereMonth('booking.created_at', now()->subMonth()->month)
                            ->count();
                        $percentChange = $lastMonthOrders > 0 ? round((($orderCount - $lastMonthOrders) / $lastMonthOrders) * 100) : 0;
                    @endphp
                    @if($percentChange > 0)
                        ↑ {{$percentChange}}% from last month
                    @elseif($percentChange < 0)
                        ↓ {{abs($percentChange)}}% from last month
                    @else
                        No change from last month
                    @endif
                </p>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-xl overflow-hidden transition-transform duration-300 hover:-translate-y-1">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-lg">Total Managers</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">
                    @if ($managertotal==0)
                        0
                    @else
                        {{$managertotal}}
                    @endif
                </h2>
                <p class="text-white text-opacity-80 text-sm">Active team members</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-xl overflow-hidden transition-transform duration-300 hover:-translate-y-1">
            <div class="p-6 text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-lg">Total Cars</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">
                    @if ($cartotal==0)
                        0
                    @else
                        {{$cartotal}}
                    @endif
                </h2>
                <p class="text-white text-opacity-80 text-sm">Fleet size</p>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Booking Trends Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Booking Trends</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="bookingTrendsChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Recent Activity</h2>
                <a href="#" class="text-blue-500 hover:text-blue-700 text-sm">View All</a>
            </div>
            <div class="space-y-4">
                @php
                    $recentBookings = \App\Models\Booking::with(['customer', 'car'])
                        ->orderBy('created_at', 'desc')
                        ->take(4)
                        ->get();
                @endphp
                
                @forelse($recentBookings as $booking)
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 font-medium">New booking created</p>
                            <p class="text-gray-500 text-sm">{{ $booking->car->car_name ?? 'Unknown Car' }} • {{ $booking->customer->first_name ?? 'Unknown' }} {{ $booking->customer->last_name ?? '' }}</p>
                            <p class="text-gray-400 text-xs mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-4">No recent activity found</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Car Status Overview -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Car Status Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @php
                $availableCars = \App\Models\tbl_cars::where('car_status', 'available')->count();
                $rentedCars = \App\Models\tbl_cars::where('car_status', 'rented')->count();
                $maintenanceCars = \App\Models\tbl_cars::where('car_status', 'maintenance')->count();
                $outOfServiceCars = \App\Models\tbl_cars::where('car_status', 'out_of_service')->count();
                
                $totalCars = $cartotal > 0 ? $cartotal : 1; // Avoid division by zero
                
                $availablePercent = round(($availableCars / $totalCars) * 100);
                $rentedPercent = round(($rentedCars / $totalCars) * 100);
                $maintenancePercent = round(($maintenanceCars / $totalCars) * 100);
                $outOfServicePercent = round(($outOfServiceCars / $totalCars) * 100);
            @endphp
            
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-600 font-medium">Available</h3>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $availableCars }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $availablePercent }}%"></div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-600 font-medium">Rented</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $rentedCars }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $rentedPercent }}%"></div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-600 font-medium">Maintenance</h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $maintenanceCars }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $maintenancePercent }}%"></div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-600 font-medium">Out of Service</h3>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $outOfServiceCars }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $outOfServicePercent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Orders Table -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Latest Orders</h2>
            <a href="{{ route('admin.vieworder') }}" class="text-blue-500 hover:text-blue-700">View All Orders</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Book ID</th>
                        <th class="py-3 px-4 text-left">Customer Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Car Name</th>
                        <th class="py-3 px-4 text-left">Location</th>
                        <th class="py-3 px-4 text-left">Pickup</th>
                        <th class="py-3 px-4 text-left">Dropoff</th>
                        <th class="py-3 px-4 text-left">Total Price</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orderdata as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $order->booking->book_id }}</td>
                            <td class="py-3 px-4">{{ $order->booking->customer->first_name }} {{ $order->booking->customer->last_name }}</td>
                            <td class="py-3 px-4">{{ $order->booking->customer->email }}</td>
                            <td class="py-3 px-4">{{ $order->booking->car->car_name }}</td>
                            <td class="py-3 px-4">{{ $order->booking->Location }}</td>
                            <td class="py-3 px-4">{{ $order->booking->Pickup }}</td>
                            <td class="py-3 px-4">{{ $order->booking->dropoof }}</td>
                            <td class="py-3 px-4 font-medium text-green-600">{{ number_format($order->total, 3) }} KIP</td>
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
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.viewcar') }}" class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition-colors duration-300">
            <div class="bg-blue-100 rounded-full p-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h3 class="text-gray-800 font-medium">Add New Car</h3>
        </a>
        <a href="{{ route('admin.vieworder') }}" class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition-colors duration-300">
            <div class="bg-green-100 rounded-full p-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-gray-800 font-medium">Manage Orders</h3>
        </a>
        <a href="{{ route('admin.viewmanager') }}" class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition-colors duration-300">
            <div class="bg-purple-100 rounded-full p-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-gray-800 font-medium">Manage Staff</h3>
        </a>
        <a href="{{ route('admin.viewuser') }}" class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition-colors duration-300">
            <div class="bg-yellow-100 rounded-full p-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-gray-800 font-medium">Manage Users</h3>
        </a>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New Booking</h3>
                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.vieworder') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="">Select Customer</option>
                            @foreach(\App\Models\Cus::all() as $customer)
                                <option value="{{ $customer->cus_id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Car</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="">Select Car</option>
                            @foreach(\App\Models\tbl_cars::where('car_status', 'available')->get() as $car)
                                <option value="{{ $car->car_id }}">{{ $car->car_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Date</label>
                        <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dropoff Date</label>
                        <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Booking</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <!-- No custom CSS needed as we're using Tailwind -->
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Booking Trends Chart
        const ctx = document.getElementById('bookingTrendsChart').getContext('2d');
        
        // Get monthly booking data from PHP
        const bookingData = {!! json_encode($chartData ?? []) !!};
        
        const months = bookingData.map(item => item.month);
        const bookings = bookingData.map(item => item.bookings);
        const revenue = bookingData.map(item => item.revenue / 1000); // Convert to thousands for better scale
        
        const bookingTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Bookings',
                        data: bookings,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Revenue (thousands)',
                        data: revenue,
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 1) {
                                    label += new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'LAK',
                                        minimumFractionDigits: 0
                                    }).format(context.raw * 1000);
                                } else {
                                    label += context.raw;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Number of Bookings'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Revenue (thousands KIP)'
                        }
                    }
                }
            }
        });

        // Function to toggle filters
        function toggleFilters() {
            // Implement filter functionality here
            alert('Filter functionality will be implemented here');
        }

        // Function to show booking modal
        function showBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.remove('hidden');
        }

        // Function to close booking modal
        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.add('hidden');
        }

        console.log("Hi, I'm using the Laravel-AdminLTE package with Tailwind CSS!");
    </script>
@stop

<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Cus;
use App\Models\tbl_cars;
class ManagerCtrl extends Controller
{
    public function index()
    {
        $userID = auth()->user()->user_id;
        $cars = tbl_cars::where('user_id', $userID)->get();
        $bookingdata = Booking::with('customer:cus_id,first_name,last_name,phone_number,email', 'car:car_id,car_name')
                              ->whereIn('car_id', $cars->pluck('car_id'))
                              ->get();
        $orderdata = Order::with('booking.customer', 'booking.car')
                          ->whereIn('book_id', $bookingdata->pluck('book_id'))
                          ->orderByDesc('book_id')
                          ->limit(5)->paginate(5);
        $orderCount = Order::whereIn('book_id', $bookingdata->pluck('book_id'))->count();
        $availableCars = tbl_cars::where('user_id', $userID)
                                ->where('car_status', 'Available')
                                ->count();
        $salesPerMonth = Booking::selectRaw('
                YEAR(booking.created_at) AS year,
                MONTH(booking.created_at) AS month,
                SUM(order.total) AS total_sales
            ')
            ->join('order', 'order.book_id', '=', 'booking.book_id') 
            ->whereIn('booking.book_id', $bookingdata->pluck('book_id'))
            ->where('booking.created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->limit(6)
            ->get();
        $salesPerYear = Booking::selectRaw('
                YEAR(booking.created_at) AS year,
                SUM(order.total) AS total_sales
            ')
            ->join('order', 'order.book_id', '=', 'booking.book_id') 
            ->whereIn('booking.book_id', $bookingdata->pluck('book_id'))
            ->where('booking.created_at', '>=', now()->subYears(5))
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();
        
        if ($salesPerMonth->isEmpty()) {
            $dummyMonthly = collect();
            
            for ($i = 0; $i < 3; $i++) {
                $date = now()->subMonths($i);
                $dummyMonthly->push((object)[
                    'year' => $date->year,
                    'month' => $date->month,
                    'total_sales' => rand(500000, 2000000)
                ]);
            }
            
            $salesPerMonth = $dummyMonthly;
        }
        
        if ($salesPerYear->isEmpty()) {
            $dummyYearly = collect();
            
            for ($i = 0; $i < 2; $i++) {
                $year = now()->subYears($i)->year;
                $dummyYearly->push((object)[
                    'year' => $year,
                    'total_sales' => rand(5000000, 20000000)
                ]);
            }
            
            $salesPerYear = $dummyYearly;
        }
        return view('manager.index', compact('orderCount', 'salesPerMonth', 'salesPerYear', 'orderdata', 'availableCars'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}


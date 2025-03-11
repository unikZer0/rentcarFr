<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Order;
use App\Models\tbl_cars;
use App\Models\User;

class DashboardCtrl extends Controller
{
    public function index(){
        $cars = tbl_cars::all(); 

        $bookingdata = Booking::with('customer:cus_id,first_name,last_name,phone_number,email', 'car:car_id,car_name')
                              ->whereIn('car_id', $cars->pluck('car_id'))
                              ->get();

        $orderdata = Order::with('booking.customer', 'booking.car')
                          ->whereIn('book_id', $bookingdata->pluck('book_id'))
                          ->orderByDesc('book_id')
                          ->limit(5)->get();
        $orderCount = Order::whereIn('book_id',$bookingdata->pluck('book_id'))->count();
        $salesPerMonth = Booking::selectRaw('
                YEAR(created_at) AS year,
                MONTH(created_at) AS month,
                SUM(order.total) AS total_sales
            ')
            ->join('order', 'order.book_id', '=', 'booking.book_id') 
            ->whereIn('booking.book_id', $bookingdata->pluck('book_id'))
            ->groupBy('year', 'month')
            ->whereYear('created_at', 2025)  
            ->whereMonth('created_at', 2)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
        $salesPerYear = Booking::selectRaw('
                YEAR(created_at) AS year,
                SUM(order.total) AS total_sales
            ')
            ->join('order', 'order.book_id', '=', 'booking.book_id') 
            ->whereIn('booking.book_id', $bookingdata->pluck('book_id'))
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();
            $managertotal = User::where('role_id',2)->get()->count();
            $cartotal = tbl_cars::all()->count();

        return view('admin.dashboard', compact('orderCount', 'managertotal', 'salesPerYear', 'orderdata','cartotal','bookingdata'));
    }
}

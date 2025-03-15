<?php

namespace App\Http\Controllers;

use App\Models\tbl_cars;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Carbon\Carbon;


class TblCarsController extends Controller
{
    public function index(Request $request)
    {
        $query = tbl_cars::query()->with(['carType', 'user']);
    
        $startDate = $request->input('start');
        $endDate = $request->input('end');
    
        if ($startDate && $endDate) {
            // Convert date strings to Carbon instances for proper comparison
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
    
            // Method 1: Using a subquery (more efficient for large datasets)
            $availableCarIds = DB::table('tbl_cars')
                ->whereNotIn('car_id', function ($q) use ($startDate, $endDate) {
                    $q->select('car_id')
                        ->from('booking')
                        ->whereBetween('Pickup', [$startDate, $endDate]) // Check if booked within the period
                        ->orWhereBetween('dropoof', [$startDate, $endDate])  // Check if returned within the period
                        ->orWhere(function ($q2) use ($startDate, $endDate) {
                            $q2->where('Pickup', '<=', $startDate) // Start date is before the booking period
                               ->where('dropoof', '>=', $endDate); // End date is after the booking period
                        });
                })
                ->pluck('car_id');
    
            $cars = $query->whereIn('car_id', $availableCarIds)->get();
    
        } else {
            $cars = $query->get(); // If no dates are provided, return all cars
        }
    
        return response()->json([
            'message' => 'Cars retrieved successfully',
            'data' => $cars,
        ], 200);
    }
    public function car_testcors()
    {
        // dd(tbl_cars::all());
        return response()->json(tbl_cars::all());
    }
}

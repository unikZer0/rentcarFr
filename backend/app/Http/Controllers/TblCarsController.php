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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function store(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'car_name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'quantity' => 'required|integer|min:0',
    //         'image' => 'nullable|string|max:255',
    //         'car_type_id' => 'required|integer|exists:tbl_cars_types,car_type_id',
    //         'car_status' => 'required|string|in:available,sold',
    //     ]);
    
    //     // Raw SQL query
    //     $sql = "INSERT INTO tbl_cars (car_name, description, quantity, image, car_type_id, car_status, created_at, updated_at)
    //             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    //     DB::statement($sql, [
    //         $request->car_name,
    //         $request->description,
    //         $request->quantity,
    //         $request->image,
    //         $request->car_type_id,
    //         $request->car_status,
    //         now(),
    //         now(),
    //     ]);
    
    //     return response()->json([
    //         'message' => 'Car added successfully',
    //     ], 201);
    // }
    
    

    /**
     * Display a listing of cars.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  public function index(Request $request)
    //  {
    //     $query = tbl_cars::query()->with(['carType', 'user']);
     
    //     //  if ($request->has('status')) {
    //     //      $query->where('tbl_cars.car_status', $request->status);
    //     //  }
     
    //     //  if ($request->has('type_id')) {
    //     //      $query->where('tbl_cars.car_type_id', $request->type_id);
    //     //  }
    //     // รับวันที่เริ่มต้นและสิ้นสุดจาก Request
    //     $startDate = $request->input('start');
    //     $endDate = $request->input('end'); 
        
    //      $cars = $query->get();
     
    //      return response()->json([
    //          'message' => 'Cars retrieved successfully',
    //          'data' => $cars,
    //      ], 200);
    //  }
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
    
    
            // Method 2: Using whereDoesntHave (less efficient for large datasets)
    
            // $cars = $query->whereDoesntHave('booking', function ($q) use ($startDate, $endDate) {
            //     $q->whereBetween('Pickup', [$startDate, $endDate])
            //         ->orWhereBetween('dropoof', [$startDate, $endDate])
            //         ->orWhere(function ($q2) use ($startDate, $endDate) {
            //             $q2->where('Pickup', '<=', $startDate)
            //                ->where('dropoof', '>=', $endDate);
            //         });
            // })->get();
    
    
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

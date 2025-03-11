<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cus;
use App\Models\Order; 
use App\Models\Booking;
use App\Models\tbl_cars;
class searchDataController extends Controller
{
    public function store(Request $request)
    {
         $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
        ]);

        $phoneNumber = $request['phone_number'];

if (strpos($phoneNumber, '020') !== 0) {
        if (strpos($phoneNumber, '02') === 0 || strpos($phoneNumber, '20') === 0) {
            $phoneNumber = '020' . substr($phoneNumber, 2);
        } else {
            $phoneNumber = '020' . $phoneNumber;
        }
    }

    $request['phone_number'] = $phoneNumber;
    // ทดสอบ
    // dd($request['phone_number']);
    
    
    
        $customer = Cus::where('email', $request->input('email'))
            ->where('phone_number', $request->input('phone_number'))
            ->first();
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
        $bookings = Booking::where('cus_id', $customer->cus_id)->get();
        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found'], 404);
        }
    
        $bookingIds = $bookings->pluck('book_id');
        $car = tbl_cars::where('car_id', $bookings->first()->car_id)->first();
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $orders = Order::whereIn('book_id', $bookingIds)->get();
    
        return response()->json([
            'customer' => $customer,
            'bookings' => $bookings,
            'car' => $car,
            'orders' => $orders
        ]);
    }
    //delete form cus 
    //delete form cus
    public function destroy($id)  
    {
        $customer = Cus::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
        }


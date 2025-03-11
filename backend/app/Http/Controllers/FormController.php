<?php

namespace App\Http\Controllers;

use App\Models\Cus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    // Index method (optional, depends on your needs)
    public function index()
    {
        $Cus = Cus::all();
        return response()->json($Cus);
    }

    // Store method (which you've already defined)

    public function store(Request $request)
    {
        // if ($request->hasFile('image')) {
        //     return response()->json(['message' => 'File received', 'file' => $request->file('image')->getClientOriginalName()]);
        // } else {
        //     return response()->json(['error' => 'No file received'], 400);
        // }
        
        try {
    
            $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'age' => 'nullable|integer|max:120',
                'phone_number' => 'nullable|string|max:20',
                'email' => 'nullable|email',
                'zipcode' => 'nullable|integer',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
    
                // Add validations for booking and order related data
                'car_id' => 'required|integer',
                'pick_up_and_dropoff' => 'required|string',
                'pick_time' => 'required|date',
                'drop_time' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'days' => 'required|integer',
                'total' => 'required|numeric',
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
            
    
            $imagePath = null;
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('images', $filename, 'public');
                $imagePath = 'storage/' . $filePath;
            }
            // Create the Customer record (formerly Cus)
            $customer = Cus::create([ // Use Customer class here
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'age' => $request->input('age'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'zipcode' => $request->input('zipcode'),
                'image' => $imagePath,
            ]);
    
    
            // Create the Booking record
            $booking = Booking::create([
                'car_id' => $request->input('car_id'),
                'Location' => $request->input('pick_up_and_dropoff'),
                'Pickup' => $request->input('pick_time'),
                'dropoof' => $request->input('drop_time'),
                'start' => $request->input('start_time'),
                'end' => $request->input('end_time'),
                'cus_id' => $customer->cus_id, 
            ]);
            // Create the Order record
            $order = Order::create([
                'book_id' => $booking->book_id, 
                'total' => $request->input('total'),
                'days' => $request->input('days'),
            ]);
    
            return response()->json([
                'message' => 'Customer, Booking, and Order created successfully',
                'data' => [
                    'customer' => $customer,
                    'booking' => $booking,
                    'order' => $order,
                ],
            ], 201);
    
        } catch (\Exception $e) {
                    Log::error('Error in tblUserController@store: ' . $e->getMessage());
                    return response()->json([
                        'message' => 'An error occurred.',
                        'error' => $e->getMessage(),
                    ], 500);
                }   
    }
    // Destroy method
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error in tblUserController@destroy: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

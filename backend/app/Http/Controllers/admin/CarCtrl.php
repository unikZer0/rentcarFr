<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_cars;
use App\Models\tbl_cars_types;
use App\Models\Booking;
use App\Models\Order;
class CarCtrl extends Controller
{
    public function viewcar()
    {
        $cartypes = tbl_cars_types::all();
        $cardata = tbl_cars::with(
            'user:user_id,name',
            'carType:car_type_id,car_type_name'
        )
        ->paginate(5);
        return view('admin.viewcar', compact('cardata', 'cartypes'));
    }
    
        public function createcar(Request $request)
    {
        $data = $request->validate([
            'car_name' => 'required',
            'descriptions' => 'required',
            'price_daily' => 'required',
            'car_status' => 'required',
            'car_type_id' => 'required',
        ]);
    
        $imagePath = null;
    
        $file = $request->file('image');
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images', $filename, 'public');
            $imagePath = 'storage/images/' . $filename;
        }
    
        $data = new tbl_cars;
        $data->user_id = auth()->user()->user_id;
        $data->car_name = $request->car_name;
        $data->descriptions = $request->descriptions;
        $data->price_daily = $request->price_daily;
        $data->car_status = $request->car_status;
        $data->image = $imagePath;
        $data->car_type_id = $request->car_type_id;
        $data->save();
    
        return redirect()->route('admin.viewcar')->with('success', 'Car created successfully!');
    }
    public function updatecar(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'car_name' => 'required',
                'descriptions' => 'required',
                'price_daily' => 'required|numeric',
                'car_status' => 'required',
                'car_type_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $carData = tbl_cars::find($request->car_id);
            if (!$carData) {
                return response()->json(['errors' => ['Car not found!']], 404);
            }
    
            $carData->car_name = $request->car_name;
            $carData->descriptions = $request->descriptions;
            $carData->price_daily = $request->price_daily;
            $carData->car_status = $request->car_status;
            $carData->car_type_id = $request->car_type_id;
    
            if ($request->hasFile('image')) {
                $filename = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('images', $filename, 'public');
                $carData->image = 'storage/images/' . $filename;
            }
    
            $carData->save();
    
            return response()->json(['success' => 'Car details updated successfully!']);
        }
    
        return response()->json(['errors' => ['Invalid request']], 400);
    }
    
        public function editcar(Request $request)
        {
            if ($request->ajax()) {
                $carData = tbl_cars::findOrFail($request->car_id);
                return response()->json(['carData' => $carData]);
            }
        }
    
        public function deletecar($id)
        {
            $data = tbl_cars::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.viewcar')->with('success', "car deleted");
        }
        public function vieworder()
        {
            $bookingdata = Booking::with('customer:cus_id,first_name,last_name,phone_number,email', 'car:car_id,car_name')->get();
        $orderdata = Order::with('booking.customer', 'booking.car')
                          ->whereIn('book_id', $bookingdata->pluck('book_id'))
                          ->orderBy('book_id')
                          ->paginate(5);
            return view('admin.vieworder', compact('orderdata'));
        }
}

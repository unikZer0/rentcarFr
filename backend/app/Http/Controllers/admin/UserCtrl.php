<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_cars;
use App\Models\tbl_cars_types;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use App\Models\Cus;
use Illuminate\Support\Facades\Storage;

class UserCtrl extends Controller
{
    public function viewcustomer(){
        $customer = Cus::paginate(3);
        return view('admin.viewuser',compact('customer'));
    }
    public function updateCustomer(Request $request)
    {
        
        $request->validate([
            'cus_id' => 'required|exists:customer,cus_id', 
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $customer = Cus::findOrFail($request->cus_id);

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->age = $request->age;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->zipcode = $request->zipcode;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->country = $request->country;
        if ($request->hasFile('image')) {
            if ($customer->image && Storage::exists($customer->image)) {
                Storage::delete($customer->image);
            }
            $path = $request->file('image')->store('customer_images');
            $customer->image = $path;  
        }

        $customer->save();
        return response()->json(['success' => true, 'message' => 'Customer updated successfully!']);
    }


    public function editcustomer(Request $request)
    {
        if ($request->ajax()) {
            $cusData = Cus::findOrFail($request->cus_id);
            return response()->json(['cusData' => $cusData]);
        }
    }

    public function deletecustomer($id)
    {
        $data = Cus::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.viewuser')->with('success', "customer deleted");
    }
}

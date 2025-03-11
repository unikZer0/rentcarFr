<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_cars;
use App\Models\tbl_cars_types;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class ManagerCtrl extends Controller
{
    //use for manage manager in our web
    public function viewmanager(){
        $manager = User::where('role_id',2)->paginate(5);
        return view('admin.viewmanager',compact('manager'));
    }
    public function updatemanager(Request $request)
{
    if ($request->ajax()) {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = User::find($request->car_id);

        if (!$userData) {
            return response()->json(['errors' => ['userData not found!']], 404);
        }

        $userData->name = $request->name;

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('profile_images', $filename, 'public');
            $userData->image = 'profile_images/' . $filename;
        }

        $userData->save();

        return response()->json(['success' => 'Car details updated successfully!']);
    }

    return response()->json(['errors' => ['Invalid request']], 400);
}

    
        public function editmanager(Request $request)
        {
            if ($request->ajax()) {
                $userData = User::findOrFail($request->user_id);
                return response()->json(['userData' => $userData]);
            }
        }
    
        public function deletemanager($id)
        {
            $data = User::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.viewmanager')->with('success', "car deleted");
        }
}

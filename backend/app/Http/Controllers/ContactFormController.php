<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactFormController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage from API.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            Contact::create($validated);

            return response()->json([
                'success' => true, 
                'message' => 'ຂໍ້ຄວາມຂອງທ່ານໄດ້ຖືກສົ່ງສຳເລັດແລ້ວ!'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display all messages (for admin).
     */
    public function viewMessages()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    /**
     * Mark message as read.
     */
    public function markAsRead($id)
    {
        $message = Contact::findOrFail($id);
        $message->status = 'read';
        $message->save();
        
        return redirect()->back()->with('success', 'Message marked as read');
    }

    /**
     * Mark message as replied.
     */
    public function markAsReplied($id)
    {
        $message = Contact::findOrFail($id);
        $message->status = 'replied';
        $message->save();
        
        return redirect()->back()->with('success', 'Message marked as replied');
    }

    /**
     * Delete a message.
     */
    public function deleteMessage($id)
    {
        $message = Contact::findOrFail($id);
        $message->delete();
        
        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}

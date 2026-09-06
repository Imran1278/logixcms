<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = Contact::latest()->paginate(15);
        $unreadCount = Contact::where('is_read', false)->count();

        return view('admin.contacts.index', compact('messages', 'unreadCount'));
    }

    public function toggleRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = !$contact->is_read;
        $contact->save();

        return back()->with('success', 'Message status updated successfully.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|max:3000',
        ]);
    
        $contact = Contact::findOrFail($id);
    
        // 1. Database me reply aur read status save karein
        $contact->admin_reply = $request->reply_message;
        $contact->is_read = true;
        $contact->replied_at = now();
        $contact->save();
    
        // 2. Email Send Karein
        Mail::to($contact->email)->send(new ContactReplyMail(
            $request->reply_message,
            $contact->message,
            $contact->name
        ));
    
        return back()->with('success', 'Reply sent to ' . $contact->email . ' and saved successfully.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('success', 'Contact message deleted successfully.');
    }
}
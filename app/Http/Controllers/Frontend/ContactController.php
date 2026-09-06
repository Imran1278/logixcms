<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Footer;

class ContactController extends Controller
{
    public function index()
    {
        $footerData = Footer::first();
        return view('frontend.contact', compact('footerData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Your message has been sent successfully! Our team will contact you soon.');
    }
}
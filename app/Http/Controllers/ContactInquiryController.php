<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInquiry;

class ContactInquiryController extends Controller
{
    // SHOW ALL CONTACTS (ADMIN PANEL)
    public function index()
    {
        $contacts = ContactInquiry::latest()->get();
        return view('pages.contact.index', compact('contacts'));
    }

    // VIEW SINGLE MESSAGE
    public function view($id)
    {
        $contact = ContactInquiry::findOrFail($id);
        return view('pages.contact.view', compact('contact'));
    }

    // STORE FROM PORTFOLIO CONTACT FORM
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required'
        ]);

        ContactInquiry::create($request->all());

        return back()->with('success', 'Message sent successfully!');
    }

    // DELETE MESSAGE
    public function delete($id)
    {
        $contact = ContactInquiry::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success','Contact Deleted Successfully');
    }

}

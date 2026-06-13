<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contact inquiries.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('admin.pages.contacts.index', compact('contacts'));
    }

    /**
     * Remove the specified contact inquiry from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact inquiry deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show()
    {
        $candidates = Candidate::approved()->orderBy('name')->get();
        return view('contact', compact('candidates'));
    }

    public function index()
    {
        $candidates = Candidate::approved()->orderBy('name')->get();
        return view('contact', compact('candidates'));
    }

    /**
     * Show contact enquiries to administrators.
     */
    public function adminIndex(Request $request)
    {
        $contacts = Contact::with('candidate')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'type' => 'required|in:general,candidate_inquiry,partnership,technical_support,license_request,media',
            'candidate_id' => 'nullable|exists:candidates,id',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'content' => $request->content,
            'type' => $request->type,
            'candidate_id' => $request->candidate_id,
            'is_read' => false,
            'status' => 'pending',
        ]);

        // Optional: Send email notification to admin
        // Mail::to('admin@constituencyproject.org')->send(new ContactFormSubmitted($contact));

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you shortly.');
    }
}

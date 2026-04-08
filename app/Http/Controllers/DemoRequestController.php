<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use Illuminate\Http\Request;

class DemoRequestController extends Controller
{
    public function index()
    {
        return view('demo-request');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:30',
            'company_name'    => 'required|string|max:255',
            'job_title'       => 'required|string|max:100',
            'industry'        => 'required|string|max:100',
            'company_size'    => 'required|string|max:50',
            'country'         => 'required|string|max:100',
            'preferred_date'  => 'required|date|after_or_equal:today',
            'preferred_time'  => 'required|string|max:20',
            'areas_of_interest' => 'nullable|array',
            'notes'           => 'nullable|string|max:2000',
        ]);

        DemoRequest::create($validated);

        return redirect()->route('demo.request')->with('success', 'Thank you! We\'ll confirm your demo within 24 hours.');
    }
}

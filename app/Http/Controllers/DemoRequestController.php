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
            'full_name'       => 'required|string|max:200',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:30',
            'company_name'    => 'required|string|max:255',
            'job_title'       => 'required|string|max:100',
            'industry'        => 'required|string|max:100',
            'company_size'    => 'required|string|max:50',
            'country'         => 'required|string|max:100',
            'preferred_date'  => 'required|date|after_or_equal:today',
        ]);

        DemoRequest::create($validated);

        return redirect()->route('demo.request')->with('success', 'Thank you! We\'ll confirm your demo within 24 hours.');
    }
}

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
            'company_name' => 'required|string|max:255',
            'full_name'    => 'required|string|max:200',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:30',
        ]);

        DemoRequest::create($validated);

        return redirect()->route('demo.request')->with('success', 'Thank you! We\'ll confirm your demo within 24 hours.');
    }
}

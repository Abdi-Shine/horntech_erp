<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use Illuminate\Http\Request;

class DemoRequestController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $company = $user ? \App\Models\Company::find($user->company_id) : null;

        $prefill = [
            'company_name' => old('company_name', $company->name ?? ''),
            'full_name'    => old('full_name',    $user->name ?? ''),
            'email'        => old('email',        $user->email ?? ''),
            'phone'        => old('phone',        $user->phone ?? $company->phone ?? ''),
        ];

        return view('demo-request', compact('prefill'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'full_name'    => 'required|string|max:200',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:30',
        ]);

        DemoRequest::create(array_merge(['status' => 'pending'], $validated));

        return redirect()->route('demo.request')->with('success', 'Thank you! We\'ll confirm your demo within 24 hours.');
    }
}

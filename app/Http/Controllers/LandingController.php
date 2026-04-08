<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SubscriptionPlan;

class LandingController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();

        // Fetch host company currency for pricing display
        $hostCompany = Company::withoutGlobalScopes()
            ->where('name', 'Horntech LTD')
            ->first();
        $currency = $hostCompany->currency ?? '$';

        return view('landing', compact('plans', 'currency'));
    }
}

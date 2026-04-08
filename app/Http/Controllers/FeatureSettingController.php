<?php

namespace App\Http\Controllers;

use App\Models\FeatureSetting;
use Illuminate\Http\Request;

class FeatureSettingController extends Controller
{
    public function index()
    {
        $settings = FeatureSetting::all()->groupBy('category');
        
        $modules = [
            'sales' => ['title' => 'Sales & POS Module', 'icon' => 'bi-cart-check', 'desc' => 'Point of Sale and sales management features'],
            'inventory' => ['title' => 'Inventory & Warehouse', 'icon' => 'bi-box-seam', 'desc' => 'Stock management and warehouse operations'],
            'purchase' => ['title' => 'Purchase & Vendors', 'icon' => 'bi-truck', 'desc' => 'Purchase orders and vendor management'],
            'hr' => ['title' => 'HR & Payroll', 'icon' => 'bi-people', 'desc' => 'Human resources and payroll management'],
            'finance' => ['title' => 'Finance & Accounting', 'icon' => 'bi-bank', 'desc' => 'Financial management and accounting features'],
            'reports' => ['title' => 'Reports & Analytics', 'icon' => 'bi-bar-chart-line', 'desc' => 'Business intelligence and reporting'],
        ];

        // Merge DB features into the modules array
        foreach ($modules as $key => &$module) {
            $module['features'] = $settings->get($key, collect())->map(function($f) {
                return [
                    'id' => $f->feature_key, // For the ID in toggle
                    'key' => $f->feature_key, // Original key
                    'name' => $f->title,
                    'desc' => $f->description,
                    'enabled' => $f->is_enabled
                ];
            })->toArray();
        }

        return view('frontend.setting.settings_features', compact('modules'));
    }

    public function update(Request $request)
    {
        if (!auth()->user()->hasPermission('System Admin', 'edit')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. System Admin permission required.'], 403);
        }

        $features = $request->input('features', []);

        foreach ($features as $key => $isEnabled) {
            FeatureSetting::where('feature_key', $key)->update([
                'is_enabled' => filter_var($isEnabled, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        return response()->json(['success' => true, 'message' => 'System features updated successfully.']);
    }

    public function reset()
    {
        if (!auth()->user()->hasPermission('System Admin', 'edit')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. System Admin permission required.'], 403);
        }

        FeatureSetting::query()->update(['is_enabled' => true]);

        return response()->json(['success' => true, 'message' => 'All system modules have been enabled.']);
    }
}

<?php
use App\Models\Customer;

try {
    Customer::updateOrCreate(['customer_code' => 'C-001-AHM'], [
        'name' => 'Ahmed Mohamed',
        'email' => 'ahmed@example.com',
        'phone' => '252615555555',
        'customer_type' => 'individual',
        'address' => 'Waberi, Mogadishu',
        'amount_balance' => 1250,
        'status' => 'active'
    ]);
    
    Customer::updateOrCreate(['customer_code' => 'C-002-HOD'], [
        'name' => 'Hodan Retail Group',
        'email' => 'info@hodan.com',
        'phone' => '252616666666',
        'customer_type' => 'business',
        'address' => 'Hodan, Mogadishu',
        'amount_balance' => 4500,
        'status' => 'active'
    ]);
    
    Customer::updateOrCreate(['customer_code' => 'C-003-BAR'], [
        'name' => 'Barawe Traders',
        'email' => 'contact@barawe.com',
        'phone' => '252617777777',
        'customer_type' => 'business',
        'address' => 'Hamar Weyne, Mogadishu',
        'amount_balance' => 0.00,
        'status' => 'inactive'
    ]);
    
    Customer::updateOrCreate(['customer_code' => 'C-004-SAM'], [
        'name' => 'Samir Supplies',
        'email' => 'samir@supplies.so',
        'phone' => '252618888888',
        'customer_type' => 'company',
        'address' => 'Waberi, Mogadishu',
        'amount_balance' => 750,
        'status' => 'active'
    ]);
    
    echo "Done! Total customers: " . Customer::count();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

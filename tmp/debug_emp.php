<?php
use Illuminate\Support\Facades\Schema;
$out = "";
$columns = Schema::getColumnListing('employees');
$out .= "EMPLOYEES COLUMNS:\n" . print_r($columns, true) . "\n";

$user = \App\Models\User::first();
$out .= "USER FIRST:\n" . print_r($user ? $user->toArray() : 'NULL', true) . "\n";

if ($user) {
    $employee = \App\Models\Employee::where('user_id', $user->id)->first();
    $out .= "EMPLOYEE FOR USER:\n" . print_r($employee ? $employee->toArray() : 'NULL', true) . "\n";
}

file_put_contents('d:/Bilkheyr/tmp/debug_emp_out.txt', $out);

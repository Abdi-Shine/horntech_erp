<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create the employees table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('employee_id');
            $table->string('national_id')->nullable();
            $table->string('title')->nullable();
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('branch')->nullable();
            $table->string('store')->nullable();
            $table->string('company')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['company_id', 'employee_id']);
        });

        // 2. Clean up users table - Remove redundant columns
        Schema::table('users', function (Blueprint $table) {
            $colsToDrop = [
                'employee_id',
                'national_id',
                'Fullname',
                'phone',
                'address',
                'company',
                'title',
                'dob',
                'gender',
                'marital_status',
                'district',
                'country',
                'designation',
                'department',
                'branch',
                'store',
                'salary',  
                'status',
            ];

            foreach ($colsToDrop as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
            
            // Ensure 'name' exists (it might have been missing if only 'full_name' was used)
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        // Note: Re-adding columns to users in 'down' is complex due to the number of columns, 
        // usually in dev we just migrate:fresh.
    }
};

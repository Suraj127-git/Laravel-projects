<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // $table->renameColumn('emp_name', 'employee_name');// Renaming "emp_name" to "employee_name"
            // $table->string('gender',10)->change(); // Change Datatype length
            // $table->dropColumn('active'); // Remove "active" field
            $table->string('instamojo_id')->nullable()->after('stripe_id'); // Add "paypal_id" column
            // $table->string('paypal_id')->change()->nullable(); // change datatype
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

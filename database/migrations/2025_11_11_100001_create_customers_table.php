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
        Schema::create('customers', function (Blueprint $table) {
           $table->id('customer_id');
            $table->string('fullname');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_number')->unique();
            $table->string('address')->nullable();
            $table->timestamp('createdAt')->useCurrent();
            $table->foreignId('createdBy')->nullable()->constrained('users', 'user_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

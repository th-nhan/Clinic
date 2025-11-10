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
        Schema::create('history_details', function (Blueprint $table) {
            $table->id('history_detail_id');
            $table->foreignId('history_id')->constrained('histories', 'history_id')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services', 'service_id');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_details');
    }
};

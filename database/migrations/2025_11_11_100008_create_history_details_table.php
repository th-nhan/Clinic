<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_details', function (Blueprint $table) {
            $table->id('history_detail_id');

            $table->foreignId('history_id')
                  ->constrained('histories', 'history_id')
                  ->onDelete('cascade');
            $table->foreignId('service_id')
                  ->constrained('services', 'service_id')
                  ->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 3)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_details');
    }
};

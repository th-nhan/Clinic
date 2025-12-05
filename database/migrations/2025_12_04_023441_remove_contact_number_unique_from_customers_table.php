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
        // *** Sử dụng Schema::table để chỉnh sửa bảng đã tồn tại ***
        Schema::table('customers', function (Blueprint $table) {
            // Tên index mặc định của Laravel là 'tênbảng_têncột_unique'
            $table->dropUnique(['contact_number']); 
            
            // HOẶC nếu bạn đã có nhiều dữ liệu trùng lặp, bạn có thể chạy dòng dưới
            // để đảm bảo không có lỗi xảy ra khi gỡ bỏ index.
            // $table->dropUnique('customers_contact_number_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hoàn tác: Thêm lại ràng buộc UNIQUE
        Schema::table('customers', function (Blueprint $table) {
            // Dùng change() để áp dụng lại thuộc tính unique
            $table->string('contact_number')->unique()->change();
        });
    }
};
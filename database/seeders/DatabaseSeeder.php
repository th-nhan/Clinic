<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN');

        // 1️⃣ Roles
        $roleAdminId = DB::table('roles')->insertGetId([
            'name' => 'admin',
            'description' => 'Quản trị viên toàn quyền',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'role_id');

        $roleStaffId = DB::table('roles')->insertGetId([
            'name' => 'staff',
            'description' => 'Nhân viên',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'role_id');

        $roleCustomerId = DB::table('roles')->insertGetId([
            'name' => 'customer',
            'description' => 'Khách hàng',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'role_id');

        // 2️⃣ Người dùng: admin + staff
        $adminId = DB::table('users')->insertGetId([
            'fullname' => 'Admin Hệ Thống',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'avatar' => null,
            'date_of_birth' => now()->subYears(30)->toDateString(),
            'gender' => 'male',
            'description' => 'Quản trị viên hệ thống',
            'contact_number' => $faker->unique()->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now(),
        ], 'user_id');

        // 4 nhân viên
        $staffIds = [];
        for ($i = 1; $i <= 4; $i++) {
            $staffIds[] = DB::table('users')->insertGetId([
                'fullname' => $faker->name(),
                'email' => "staff{$i}@example.com",
                'password' => Hash::make('password'),
                'avatar' => null,
                'date_of_birth' => $faker->date(),
                'gender' => $faker->randomElement(['male', 'female']),
                'description' => $faker->sentence(),
                'contact_number' => $faker->unique()->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ], 'user_id');
        }

        // 3️⃣ Gán vai trò cho người dùng
        if (DB::getSchemaBuilder()->hasTable('role_user')) {
            DB::table('role_user')->insert([
                ['role_id' => $roleAdminId, 'user_id' => $adminId],
            ]);
            foreach ($staffIds as $sid) {
                DB::table('role_user')->insert([
                    ['role_id' => $roleStaffId, 'user_id' => $sid],
                ]);
            }
        }

        // 4️⃣ Khách hàng
        $customerIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $customerIds[] = DB::table('customers')->insertGetId([
                'fullname' => $faker->name(),
                'date_of_birth' => $faker->optional()->date(),
                'gender' => $faker->randomElement(['male', 'female']),
                'contact_number' => $faker->unique()->phoneNumber(),
                'address' => $faker->address(),
                'createdAt' => now(),
                'createdBy' => $adminId,
            ], 'customer_id');
        }

        // 5️⃣ Danh mục dịch vụ
        $categoryIds = [];
        $categoryNames = ['Chung', 'Thẩm Mỹ', 'Nha Khoa'];
        foreach ($categoryNames as $name) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'name' => $name,
                'description' => "Dịch vụ $name",
                'created_at' => now(),
                'updated_at' => now(),
            ], 'category_id');
        }

        // 6️⃣ Dịch vụ
        $serviceIds = [];
        foreach ($categoryIds as $cid) {
            for ($j = 1; $j <= 3; $j++) {
                $serviceIds[] = DB::table('services')->insertGetId([
                    'category_id' => $cid,
                    'name' => $faker->words(2, true),
                    'image' => null,
                    'description' => $faker->sentence(),
                    'min_price' => $faker->randomFloat(2, 50, 200),
                    'max_price' => $faker->randomFloat(2, 201, 1000),
                    'unit' => 'lần',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ], 'service_id');
            }
        }

        // 7️⃣ Thời gian khám
        $timeSlots = [
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['11:00:00', '12:00:00'],
            ['13:00:00', '14:00:00'],
            ['14:00:00', '15:00:00'],
        ];
        $scheduleTimeIds = [];
        foreach ($timeSlots as $slot) {
            $scheduleTimeIds[] = DB::table('schedule_times')->insertGetId([
                'start_time' => $slot[0],
                'end_time' => $slot[1],
                'created_at' => now(),
                'updated_at' => now(),
            ], 'schedule_time_id');
        }

        // 8️⃣ Lịch làm việc cho nhân viên, 7 ngày tới
        $scheduleIds = [];
        foreach ($staffIds as $sid) {
            for ($d = 0; $d < 7; $d++) {
                $date = now()->addDays($d)->toDateString();
                foreach ($scheduleTimeIds as $stid) {
                    $scheduleIds[] = DB::table('schedules')->insertGetId([
                        'user_id' => $sid,
                        'schedule_time_id' => $stid,
                        'date' => $date,
                        'status' => 'available',
                        'createdAt' => now(),
                        'createdBy' => $adminId,
                    ], 'schedule_id');
                }
            }
        }

        // 9️⃣ Lịch sử khám
        $historyIds = [];
        foreach ($customerIds as $cid) {
            $staffId = $faker->randomElement($staffIds);
            $historyIds[] = DB::table('histories')->insertGetId([
                'customer_id' => $cid,
                'user_id' => $staffId,
                'date' => $faker->date(),
                'time' => $faker->time(),
                'noted' => $faker->sentence(),
                'createdAt' => now(),
                'createdBy' => $adminId,
            ], 'history_id');
        }

        // 9.1️⃣ History Details: mỗi lịch sử khám 1-3 dịch vụ
        foreach ($historyIds as $hid) {
            $detailsCount = $faker->numberBetween(1, 3);
            $pickedServices = $faker->randomElements($serviceIds, $detailsCount);

            foreach ($pickedServices as $sid) {
                DB::table('history_details')->insert([
                    'history_id' => $hid,
                    'service_id' => $sid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 10️⃣ Hóa đơn: mỗi lịch sử khám 1 hóa đơn
        foreach ($historyIds as $hid) {
            $staffId = $faker->randomElement($staffIds);
            DB::table('invoices')->insert([
                'history_id' => $hid,
                'user_id' => $staffId,
                'total_price' => $faker->randomFloat(2, 50, 2000),
                'method_payment' => $faker->randomElement(['cash','momo']),
                'status' => $faker->randomElement(['paid','unpaid']),
                'createdAt' => now(),
            ]);
        }

        // 11️⃣ Lịch hẹn (Appointments)
        $appointmentIds = [];
        for ($i = 0; $i < 15; $i++) {
            $custId = $faker->randomElement($customerIds);
            $staffId = $faker->randomElement($staffIds);
            $stimeId = $faker->randomElement($scheduleTimeIds);
            $date = now()->addDays($faker->numberBetween(0, 6))->toDateString();

            $appointmentIds[] = DB::table('appointments')->insertGetId([
                'user_id' => $staffId,
                'contact_number' => $faker->phoneNumber(),
                'time' => DB::raw("(SELECT start_time FROM schedule_times WHERE schedule_time_id = $stimeId)"),
                'date' => $date,
                'noted' => $faker->optional()->sentence(),
                'status' => $faker->randomElement(['pending','confirmed','cancelled']),
                'created_at' => now(),
                'updated_at' => now(),
            ], 'appointment_id');
        }

        // 12️⃣ Chi tiết lịch hẹn
        foreach ($appointmentIds as $aid) {
            $detailsCount = $faker->numberBetween(1, 2);
            $pickedServices = $faker->randomElements($serviceIds, $detailsCount);
            foreach ($pickedServices as $sid) {
                DB::table('appointment_details')->insert([
                    'appointment_id' => $aid,
                    'service_id' => $sid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

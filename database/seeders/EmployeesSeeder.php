<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        
        $faker = Faker::create('id_ID');

        // **1️⃣ Hapus dulu data lama**
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('attendances')->truncate();
        DB::table('salaries')->truncate();
        DB::table('employees')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // **2️⃣ Buat Admin DEFAULT**
        $adminUser = User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@hrisense.com',
            'password' => Hash::make('pw'),
            'role'     => 'admin',
        ]);

        $adminEmployee = Employee::create([
            'user_id'       => $adminUser->id,
            'nama_lengkap'  => 'Administrator',
            'email'         => 'admin@hrisense.com',
            'nomor_telepon' => '081111111111',
            'tanggal_lahir' => '1990-01-01',
            'alamat'        => 'Kantor Pusat HRISense',
            'tanggal_masuk' => now(),
            'departemen_id' => 1,
            'jabatan_id'    => 1,
            'status'        => 'aktif',
        ]);

        // **3️⃣ Buat Staff DEFAULT**
        $staffUser = User::create([
            'name'     => 'Staff Default',
            'username' => 'staff',
            'email'    => 'staff@hrisense.com',
            'password' => Hash::make('pw'),
            'role'     => 'staff',
        ]);

        $staffEmployee = Employee::create([
            'user_id'       => $staffUser->id,
            'nama_lengkap'  => 'Staff Default',
            'email'         => 'staff@hrisense.com',
            'nomor_telepon' => '082222222222',
            'tanggal_lahir' => '1995-01-01',
            'alamat'        => 'Cabang HRISense',
            'tanggal_masuk' => now(),
            'departemen_id' => 2,
            'jabatan_id'    => 3,
            'status'        => 'aktif',
        ]);

        // **4️⃣ Generate Dummy Lain**
        $departments = [1, 2, 3, 4];
        $positions   = [1, 2, 3, 4];

        for ($i = 0; $i < 15; $i++) {
            $name = $faker->name();
            $email = strtolower(str_replace(' ', '', $name)) . '@company.com';

            $employee = Employee::create([
                'nama_lengkap'  => $name,
                'email'         => $email,
                'nomor_telepon' => '08' . $faker->numberBetween(1000000000, 9999999999),
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-12-31'),
                'alamat'        => $faker->address(),
                'tanggal_masuk' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'departemen_id' => $faker->randomElement($departments),
                'jabatan_id'    => $faker->randomElement($positions),
                'status'        => 'aktif',
            ]);

            User::create([
                'name'     => $name,
                'username' => strtolower(explode(' ', $name)[0]) . $i,
                'email'    => $email,
                'password' => Hash::make('pw'),
                'role'     => 'staff',
            ]);
        }
    }
}

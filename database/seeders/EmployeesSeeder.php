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

        $departments = [
            1 => 'Human Resource',
            2 => 'Finance',
            3 => 'IT',
            4 => 'Marketing',
        ];

        $positions = [
            1 => 'Manager',
            2 => 'Supervisor',
            3 => 'Staff',
            4 => 'Intern',
        ];

        $employees = [];

        foreach ($departments as $deptId => $deptName) {
            foreach ($positions as $posId => $posName) {
                $employees[] = [
                    'nama_lengkap'   => $faker->name(),
                    'email'          => strtolower($posName) . '.' . strtolower(str_replace(' ', '', $deptName)) . '@company.com',
                    'nomor_telepon'  => '08' . $faker->numberBetween(1000000000, 9999999999),
                    'tanggal_lahir'  => $faker->date('Y-m-d', '2000-12-31'),
                    'alamat'         => $faker->address(),
                    'tanggal_masuk'  => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                    'departemen_id'  => $deptId,
                    'jabatan_id'     => $posId,
                    'status'         => 'aktif',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        DB::table('employees')->insert($employees);

        // Ambil semua employee setelah insert
        $allEmployees = Employee::all();

        foreach ($allEmployees as $index => $employee) {
            $firstWord = strtolower(explode(' ', $employee->nama_lengkap)[0]);
            $baseUsername = preg_replace('/[^a-z0-9]/', '', $firstWord);
            $username = $baseUsername;
            $counter = 1;

            // Cegah duplikasi username
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            // 3 user pertama jadi admin, sisanya staff
            $role = $index < 3 ? 'admin' : 'staff';

            $user = User::create([
                'name' => $employee->nama_lengkap,
                'username' => $username,
                'email' => $employee->email,
                'password' => Hash::make('pw'),
                'role' => $role,
            ]);

            // Hubungkan user_id ke employee
            $employee->update(['user_id' => $user->id]);
        }
    }
}

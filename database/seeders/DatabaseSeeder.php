<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Campus;
use App\Models\Department;
use App\Models\Program;
use App\Models\AdminId;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'IQA S.A.',
            'email' => 'omsc.iqaclearvault@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('OMSCIQA#2025'),
            'user_type' => 'Admin',
        ]);

        Campus::create([
            'name' => 'San Jose Campus',    
        ]);

        Department::create([
            'name' => 'CAST',
            'description' => 'Computer Arts, Science and Technology',
            'campus_id' => 1,
        ]);

        Program::create([
            'name' => 'Bachelor of Science in Information Technology',
            'department_id' => 1,
        ]);

        AdminId::insert([
            ['admin_id' => 'ADMIN20250001'],
            ['admin_id' => 'ADMIN20250002'],
            ['admin_id' => 'ADMIN20250003'],
            ['admin_id' => 'ADMIN20250004'],
            ['admin_id' => 'ADMIN20250005']
        ]);

        Office::create([
            'name' => 'MIS',
            'description' => 'Management Information System',
            'campus_id' => 1,
        ]);

        User::create([
            'name' => 'IQA SJ Admin',
            'email' => 'adminsj@iqaclearvault.com',
            'email_verified_at' => now(),
            'password' => Hash::make('OMSCIQA#2025'),
            'user_type' => 'Admin',
            'campus_id' => 1,
            'department_id' => 1,
            'program_id' => 1,
            'admin_id_registered' => 'ADMIN20250006',
        ]);

        // Call the Clearance seeder
        $this->call([
            ClearanceSeeder::class,
            ClearanceRequirementSeeder::class,
        ]);
    }
}

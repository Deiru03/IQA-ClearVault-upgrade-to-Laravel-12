<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clearance;
use App\Models\ClearanceRequirement;
use App\Models\SharedClearance;

class ClearanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed clearances
        $clearances = [
            [
                'id' => 2,
                'document_name' => 'FACULTY PORTFOLIO CHECKLIST-C',
                'description' => 'For Professional Practitioners, e.g. lawyers, doctors, accountants, police officers, school
principals, engineers, architects, with nine (9) units and below teaching loads.',
                'units' => 9,
                'type' => 'Part-Time',
                'number_of_requirements' => 9,
                'created_at' => '2025-02-03 19:37:50',
                'updated_at' => '2025-02-03 19:41:46',
            ],
            [
                'id' => 3,
                'document_name' => 'FACULTY PORTFOLIO CHECKLIST-A',
                'description' => '(For Regular and Temporary Teachers)',
                'units' => 21,
                'type' => 'Permanent-Temporary',
                'number_of_requirements' => 34,
                'created_at' => '2025-02-03 19:44:32',
                'updated_at' => '2025-02-03 19:50:45',
            ],
            [
                'id' => 4,
                'document_name' => 'FACULTY PORTFOLIO CHECKLIST-B',
                'description' => '(For part-time faculty with 12 units and above teaching loads)',
                'units' => 12,
                'type' => 'Part-Time-FullTime',
                'number_of_requirements' => 25,
                'created_at' => '2025-02-03 19:52:12', 
                'updated_at' => '2025-02-03 19:58:33',
            ],
            [
                'id' => 5,
                'document_name' => 'ACCREDITATION CHECKLIST FOR COLLEGE DEAN',
                'description' => 'Accreditation Checklist for College Dean',
                'units' => 25,
                'type' => 'Part-Time-FullTime',
                'number_of_requirements' => 21,
                'created_at' => '2025-02-03 19:59:27',
                'updated_at' => '2025-04-03 05:54:59',
            ],
            [
                'id' => 6,
                'document_name' => 'ACCREDITATION CHECKLIST FOR PROGRAM HEAD',
                'description' => 'All documents should be printed/photocopied in LONG COUPON BOND. Photocopied documents must be authenticated',
                'units' => null,
                'type' => 'Program-Head',
                'number_of_requirements' => 27,
                'created_at' => '2025-02-03 20:04:05',
                'updated_at' => '2025-02-03 20:07:49',
            ],
        ];

        // Insert clearances
        foreach ($clearances as $clearance) {
            Clearance::create($clearance);
        }

        // Seed shared clearances
        $sharedClearances = [
            ['id' => 1, 'clearance_id' => 2, 'created_at' => '2025-02-03 20:08:26', 'updated_at' => '2025-02-03 20:08:26'],
            ['id' => 2, 'clearance_id' => 3, 'created_at' => '2025-02-03 20:08:50', 'updated_at' => '2025-02-03 20:08:50'],
            ['id' => 3, 'clearance_id' => 4, 'created_at' => '2025-02-03 20:09:02', 'updated_at' => '2025-02-03 20:09:02'],
            ['id' => 4, 'clearance_id' => 6, 'created_at' => '2025-02-03 20:09:15', 'updated_at' => '2025-02-03 20:09:15'],
            ['id' => 5, 'clearance_id' => 5, 'created_at' => '2025-02-03 20:09:30', 'updated_at' => '2025-02-03 20:09:30'],
        ];
        
        foreach ($sharedClearances as $shared) {
            SharedClearance::create($shared);
        }
    }
}
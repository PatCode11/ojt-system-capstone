<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OjtSyncUserSeeder extends Seeder
{
    /**
     * Seed development users.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@ojtsync.test',
            ],
            [
                'name' => 'OJT Sync Administrator',

                'password' => Hash::make(
                    'Admin@12345'
                ),

                'role' => User::ROLE_ADMIN,

                'status' => User::STATUS_ACTIVE,
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'student@ojtsync.test',
            ],
            [
                'name' => 'Sample OJT Student',

                'password' => Hash::make(
                    'Student@12345'
                ),

                'role' => User::ROLE_STUDENT,

                'status' => User::STATUS_ACTIVE,
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'supervisor@ojtsync.test',
            ],
            [
                'name' => 'Sample OJT Supervisor',

                'password' => Hash::make(
                    'Supervisor@12345'
                ),

                'role' => User::ROLE_SUPERVISOR,

                'status' => User::STATUS_ACTIVE,
            ]
        );
    }
}
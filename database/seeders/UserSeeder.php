<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 2 admins
        User::factory()->count(2)->state(['role' => 'admin'])->create();

        // 3 organizers
        User::factory()->count(3)->state(['role' => 'organizer'])->create();

        // 10 customers
        User::factory()->count(10)->state(['role' => 'customer'])->create();
    }
}

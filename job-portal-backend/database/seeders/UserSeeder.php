<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // This role matches the check in your Sidebar.vue
            'title' => 'Administrator',
            'location' => 'Headquarters'
        ]);
        // 1. Specific Test Employer
        User::create([
            'name' => 'Test Employer',
            'email' => 'employer@example.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'title' => 'HR Manager',
            'location' => 'San Francisco, CA'
        ]);

        // 2. Specific Test Seeker
        $seeker = User::create([
            'name' => 'Test Seeker',
            'email' => 'seeker@example.com',
            'password' => Hash::make('password'),
            'role' => 'seeker',
            'title' => 'Senior Frontend Developer',
            'location' => 'Austin, TX'
        ]);

        // Attach specific skills to test seeker
        $skills = Skill::whereIn('name', ['React', 'JavaScript', 'CSS', 'Tailwind CSS'])->get();
        $seeker->skills()->attach($skills);

        // 3. Create 10 Random Employers
        User::factory(10)->create([
            'role' => 'employer'
        ]);

        // 4. Create 20 Random Seekers with Skills
        $allSkills = Skill::all();
        
        User::factory(20)->create([
            'role' => 'seeker'
        ])->each(function ($user) use ($allSkills) {
            // Attach 3-6 random skills to each seeker
            $user->skills()->attach(
                $allSkills->random(rand(3, 6))->pluck('id')->toArray()
            );
        });
    }
}
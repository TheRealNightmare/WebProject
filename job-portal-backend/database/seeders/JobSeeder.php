<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $employers = User::where('role', 'employer')->get();
        $allSkills = Skill::all();

        foreach ($employers as $employer) {
            // Create 1-3 jobs for each employer
            Job::factory(rand(1, 3))->create([
                'employer_id' => $employer->id
            ])->each(function ($job) use ($allSkills) {
                // Attach 3-5 random required skills to the job
                $job->skills()->attach(
                    $allSkills->random(rand(3, 5))->pluck('id')->toArray()
                );
            });
        }
    }
}
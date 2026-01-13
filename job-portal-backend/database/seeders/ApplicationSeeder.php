<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = Job::with('skills')->get();
        $seekers = User::where('role', 'seeker')->with('skills')->get();

        foreach ($jobs as $job) {
            // Get 0 to 5 random seekers to apply for this job
            $applicants = $seekers->random(rand(0, 5));

            foreach ($applicants as $seeker) {
                // Calculate logic match
                $jobSkills = $job->skills->pluck('id')->toArray();
                $userSkills = $seeker->skills->pluck('id')->toArray();
                
                $matchPercentage = 0;
                if (count($jobSkills) > 0) {
                    $matching = array_intersect($jobSkills, $userSkills);
                    $matchPercentage = round((count($matching) / count($jobSkills)) * 100);
                }

                Application::create([
                    'job_id' => $job->id,
                    'seeker_id' => $seeker->id,
                    'cover_letter' => fake()->paragraph(),
                    'resume_path' => 'resumes/default_resume.pdf', // Placeholder
                    'match_percentage' => $matchPercentage,
                    'status' => fake()->randomElement(['pending', 'reviewed', 'interview', 'rejected']),
                    'created_at' => fake()->dateTimeBetween('-1 month', 'now')
                ]);
            }
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Angular', 
            'Node.js', 'Python', 'Django', 'Java', 'Spring Boot', 'SQL', 
            'PostgreSQL', 'MySQL', 'Docker', 'AWS', 'Git', 'TypeScript', 
            'Tailwind CSS', 'SASS'
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
    }
}
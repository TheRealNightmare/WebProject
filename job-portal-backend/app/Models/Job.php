<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location',
        'salary_range',
        'type'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function calculateMatchForUser(User $user)
    {
        if(!$user) return 0;
        $jobSkills = $this->skills->pluck('id')->toArray();
        $userSkills = $user->skills->pluck('id')->toArray();
        if(count($jobSkills)===0) return 0;
        $matchingSkills = array_intersect($jobSkills, $userSkills);
        $percentage = (count($matchingSkills)/count($jobSkills))*100;
        return round($percentage);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'salary' => 'required',
            'type' => 'required',
            'skills' => 'required|array'
        ]);

        $job = Job::create([
            'employer_id' => auth('sanctum')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary_range' => $request->salary,
            'type' => $request->type
        ]);

        foreach($request->skills as $skillName) {
            $skill = Skill::firstOrCreate(['name' => trim($skillName)]);
            $job->skills()->attach($skill->id);
        }
        return response()->json($job);
    }

    public function myJobs(Request $request)
    {
        $jobs = Job::where('employer_id', auth('sanctum')->id())
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($jobs);
    }

    public function getApplicants($jobId) {
        $job = Job::where('id', $jobId)->where('employer_id', auth('sanctum')->id())->firstOrFail();
        $applicants = $job->applications()
           ->with(['seeker'])
           ->orderBy('match_percentage', 'desc')
           ->get();
        return response()->json($applicants);
    }

    // New method to update status
    public function updateApplicationStatus(Request $request, $jobId, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $job = Job::where('id', $jobId)->where('employer_id', auth('sanctum')->id())->firstOrFail();
        
        $application = $job->applications()->where('id', $applicationId)->firstOrFail();
        
        $application->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Application status updated successfully',
            'application' => $application
        ]);
    }
}
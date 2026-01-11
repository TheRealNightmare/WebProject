<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    
    public function apply(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $user = auth('sanctum')->user();
        $job = Job::with('skills')->findOrFail($jobId);

        $resumePath = $user->resume_path;
        if($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes','public');
        }
        
        $match = $job->calculateMatchForUser($user);

        Application::create([
            'job_id' => $jobId,
            'seeker_id' => $user->id,
            'cover_letter' => $request->cover_letter,
            'resume_path' => $resumePath,
            'match_percentage' => $match,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Application submitted successfully']);
    }
}

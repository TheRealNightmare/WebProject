<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['skills','employer']);

        if($request->has('search')) {
            $query->where('title', 'like', '%'. $request->search . '%')
                ->orWhere('location', 'like', '%'. $request->search . '%');
        }
        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        $user = auth('sanctum')->user();
        if ($user) $user->load('skills');

        $jobs->getCollection()->transform(function ($job) use ($user) {
            // FIX: Return null if not a seeker, so 0% only shows for actual seekers
            $job->match_percentage = $user && $user->role === 'seeker'
                ? $job->calculateMatchForUser($user)
                : null; 

            $job->has_applied = $user 
                ? Application::where('job_id', $job->id)->where('seeker_id', $user->id)->exists() 
                : false;

            return $job;
        });
        return response()->json($jobs);
    }

    public function show($id)
    {
        $job = Job::with(['skills','employer'])->findOrFail($id);
        $user = auth('sanctum')->user();

        if($user && $user->role === 'seeker') {
            $user->load('skills');
            $job->match_percentage = $job->calculateMatchForUser($user);
            
            $job->has_applied = Application::where('job_id', $job->id)
                ->where('seeker_id', $user->id)
                ->exists();
        } else {
            // FIX: Explicitly set to null for non-seekers
            $job->match_percentage = null;
            $job->has_applied = false;
        }
        return response()->json($job);
    }
}
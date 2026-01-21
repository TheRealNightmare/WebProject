<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application; // Import Application model
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
        $jobs = $query->orderBy('created_at', 'desc')->paginate(10); // Added ordering

        $user = auth('sanctum')->user();

        $jobs->getCollection()->transform(function ($job) use ($user) {
            // Calculate Match
            $job->match_percentage = $user && $user->role === 'seeker'
                ? $job->calculateMatchForUser($user)
                : 0;

            // Check if user has applied
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
            $job->match_percentage = $job->calculateMatchForUser($user);
            
            // Check if user has applied
            $job->has_applied = Application::where('job_id', $job->id)
                ->where('seeker_id', $user->id)
                ->exists();
        } else {
            $job->has_applied = false;
        }

        return response()->json($job);
    }
}
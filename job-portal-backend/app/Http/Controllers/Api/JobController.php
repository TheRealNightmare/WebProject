<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
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
        $jobs = $query->paginate(10);

        $user = auth('sanctum')->user();

        $jobs->getCollection()->transform(function ($job) use ($user) {
            $job->match_percentage = $user && $user->role === 'seeker'
            ? $job->calculateMatchForUser($user)
            :0;
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
        }
        return response()->json($job);
    }
}

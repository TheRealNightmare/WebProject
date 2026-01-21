<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Get dashboard stats
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),
            'seekers' => User::where('role', 'seeker')->count(),
            'employers' => User::where('role', 'employer')->count(),
            'active_jobs' => Job::count() // You can refine 'active' logic if you have a status column
        ]);
    }

    // Get all users
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    // Delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    // Get all jobs for admin management
    public function jobs()
    {
        $jobs = Job::with('employer')->withCount('applications')->orderBy('created_at', 'desc')->get();
        return response()->json($jobs);
    }

    // Delete a job
    public function deleteJob($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json(['message' => 'Job deleted successfully']);
    }
}
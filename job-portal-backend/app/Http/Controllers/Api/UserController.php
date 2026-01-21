<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill; // Make sure this is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->load('skills'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'location' => 'nullable|string',
            'skills' => 'nullable|array' // Uncommented validation
        ]);

        // 1. Update basic info
        $user->update($request->only(['name', 'email', 'location']));

        // 2. Handle Skills Update
        if ($request->has('skills')) {
            $skillIds = [];
            foreach ($request->skills as $skillName) {
                // Find or create the skill based on the name sent from frontend
                $skill = Skill::firstOrCreate(['name' => trim($skillName)]);
                $skillIds[] = $skill->id;
            }
            // Sync skills (removes unselected ones, adds new ones)
            $user->skills()->sync($skillIds);
        }

        return response()->json($user->load('skills'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
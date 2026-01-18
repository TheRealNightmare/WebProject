<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        // Return user with their skills
        return response()->json($request->user()->load('skills'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string', // Assuming you have a phone column, if not, remove
            'location' => 'nullable|string',
            'skills' => 'nullable|array'
        ]);

        $user->update($request->only(['name', 'email', 'location'])); // Add phone if exists in DB

        if ($request->has('skills')) {
            $skillIds = [];
            foreach ($request->skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => trim($skillName)]);
                $skillIds[] = $skill->id;
            }
            $user->skills()->sync($skillIds);
        }

        return response()->json($user->load('skills'));
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash
use Illuminate\Validation\ValidationException; // Import Exception

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
            // 'skills' => 'nullable|array' // Handled in Profile usually, but kept if you want
        ]);

        $user->update($request->only(['name', 'email', 'location']));

        return response()->json($user->load('skills'));
    }

    // NEW METHOD: Handle Password Update
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // expects new_password_confirmation field
        ]);

        $user = $request->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
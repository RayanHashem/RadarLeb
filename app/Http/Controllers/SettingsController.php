<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    /**
     * Verify the old password before allowing password change
     */
    public function verifyOldPassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'verified' => false,
                'message' => 'Incorrect password',
            ], 422);
        }

        return response()->json([
            'verified' => true,
        ]);
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        // Validate old password
        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify old password
        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['The provided password is incorrect.'],
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
}


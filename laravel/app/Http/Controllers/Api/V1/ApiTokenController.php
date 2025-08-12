<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    public function generateToken(Request $request): Response
    {
        // Validate credentials (e.g., hardcoded or from env)
        $validated = $request->validate([
            'system_name' => 'required|string',
            'secret_key' => 'required|string|in:' . env('M2M_SECRET_KEY'),
        ]);

        // Find or create a dedicated user for the machine
        $user = User::firstOrCreate(
            ['email' => $validated['system_name'] . '@m2m.example'],
            ['password' => Hash::make(Str::random(32))]
        );

        // Create a token with abilities (scopes)
        $token = $user->createToken('m2m-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
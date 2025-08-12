<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Throwable;

class ApiTokenController extends Controller
{
    public function generateToken(Request $request): JsonResponse
    {
        // Validate credentials (e.g., hardcoded or from env)
        $validated = $request->validate([
            'system_name' => ['required', 'string', function ($attribute, $value, $fail) {
                if (User::where('email', $value . '@m2m.wci')->exists()) {
                    $fail('The system name has already been taken.');
                }
            }],
            'secret_key' => 'required|string|in:' . env('M2M_SECRET_KEY'),
        ]);

        try {
            
            DB::beginTransaction();

            // Find or create a dedicated user for the machine
            $user = User::firstOrCreate([
                'name' => $validated['system_name'],
                'email' => $validated['system_name'] . '@m2m.wci',
                'password' => Hash::make(Str::random(32))
            ]);

            // Create a token with abilities (scopes)
            $token = $user->createToken('m2m-token')->plainTextToken;

            DB::commit();

            return response()->json(['token' => $token]);
            
        } catch (Throwable $th) {

            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
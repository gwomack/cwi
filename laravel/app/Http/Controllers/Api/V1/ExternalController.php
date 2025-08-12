<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ExternalController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $response = Http::withToken(env('TOKEN'))
                ->get(env('NODE_URL', 'http://localhost:3000') . '/health');

            return response()->json($response->json());

        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
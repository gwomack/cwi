<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\V1\UserCollection;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $users = User::whereNot('email', 'like', '%@m2m.wci')->paginate(10);

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        try {
            DB::beginTransaction();

            $user = User::create($request->validated());

            DB::commit();

            return new UserResource($user);
        } catch (Throwable $th) {

            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function show(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        try {
            DB::beginTransaction();

            $user->update($request->validated());

            DB::commit();

            return new UserResource($user);
        } catch (Throwable $th) {

            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function destroy(Request $request, User $user): Response
    {
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();

            return response()->noContent();
        } catch (Throwable $th) {

            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

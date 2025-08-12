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

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $users = User::all();

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create($request->validated());

        return new UserResource($user);
    }

    public function show(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(Request $request, User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}

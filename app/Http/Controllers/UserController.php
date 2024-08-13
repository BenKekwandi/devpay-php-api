<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    /** Get user list */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::sort()->filter()->paginate(Request::get("per_page")));
    }

    /** Store user */
    public function store(UserRequest $request): UserResource
    {
        return new UserResource(User::create($request->validated()));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    /**
     * Update the user.
     */
    public function update(User $user, UserRequest $request): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the user.
     */
    public function destroy(User $user): Response
    {
        $user->delete();
        return response()->noContent();
    }

    /**
     * Update self password.
     */
    public function me(ChangePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user->update($request->validated());
        return response()->json(new UserResource($user));
    }

    /**
     * Update user password.
     */
    public function change_password(User $user, ChangePasswordRequest $request): UserResource
    {
        $user->update($request->validated());
        return new UserResource($user);

    }
}
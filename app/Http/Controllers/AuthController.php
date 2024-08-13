<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    /**
     * @unauthenticated
     * Login user and create token
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if(Auth::attempt($request->validated())){
            $user = Auth::user();

            if ($user) {

                if($user->is_active === false){
                    return response()->json(['error'=>'User account inactive'], 403);
                }

                if(!empty($user->account) && $user->account->exists() && $user->account->is_active === false){
                    return response()->json(['error'=>'Inclusive account passive'], 403);
                }

                if(!empty($user->account) && $user->account->exists() &&  $user->account->accountGroup->is_active === false){
                    return response()->json(['error'=>'Account group passive'], 403);
                }

                $token =  $user->createToken('token')->plainTextToken;
                
            } else {
                return response()->json(['error'=>'Unauthorised'], 401);
            }

            return response()->json(['user' => UserResource::make($user), 'token' => $token]);

        } else {
            return response()->json(['error'=>'Username or password incorrect'], 401);
        }

    }

    /**
     * Get the authenticated user
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        return response()->json(UserResource::make($user));
    }

    /**
     * Log the user out (Invalidate the token)
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
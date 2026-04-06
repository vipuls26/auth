<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login
    public function login(LoginRequest $request)
    {
        // check validation
        $validator = $request->all();

        // find email of user request
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 422,
                'message' => 'email is not registered',
                'data' => $validator
            ], 422);
        } elseif (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'password is incorrect',
                'data' => $validator
            ], 401);
        } else {
            $expiresAt = Carbon::now()->addHour(24);
            $token = $user->createToken('api-token',['*'] , $expiresAt)->plainTextToken;

            return response()->json([
                'status' => '200',
                'message' => 'user login successfully',
                'token' => $token,
                'data' => $validator
            ], 200);
        }
    }

    // register
    public function register(RegisterRequest $request)
    {
        // check validation
        $validator = $request->all();

        // add user if validation passed
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        // find role submitted by user
        $role = Role::where('name', $request->role)->first();

        // add user_id with role_id in role_user
        $user->roles()->attach($role);

        // passed message after user register or fail
        if (!$user) {
            return response()->json([
                'message' => 'validation error occur',
                'data' => $validator,
                $role
            ], 401);
        } else {
            return response()->json([
                'message' => 'user register successfully',
                'data' => $validator
            ], 200);
        }
    }

    // logout
    public function logout(Request $request)
    {

        // delete access token from db
        $user = $request->user()->currentAccessToken()->delete();

        
        // pass response if failed to delete user accessToken
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'logout failed'
            ], 401);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'logout successfully'
            ], 200);
        }
    }
}

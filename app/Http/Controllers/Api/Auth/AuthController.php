<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    // login
    public function login(LoginRequest $request)
    {
        $validator = $request->all();

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'email is not registered',
                'data' => $validator
            ]);
        } elseif (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'password is incorrect',
                'data' => $validator
            ]);
        } else {

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => '200',
                'message' => 'user login successfully',
                'token' => $token,
                'data' => $validator
            ]);
        }
    }

    // register
    public function register(RegisterRequest $request)
    {

        $validator = $request->all();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->roles()->attach($role);

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'validation error occur',
                'data' => $validator
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'user register successfully',
                'data' => $validator
            ]);
        }
    }

    // logout
    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'logout failed'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'logout successfully'
            ]);
        }
    }
}

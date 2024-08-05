<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //Basic Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,user',
        ]);

        //IF validator fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        //Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        //Generate a token for the user

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => "User registered successfully"
        ], 201);
    }

    public function login(Request $request)
    {
        // Basic validation for incoming data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|email ',
            'password' => 'required|string|min:8',
        ]);

        //IF validator fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        //Find the user by email
        $user = User::where('email', $request->email)->first();

        //IF the user does not exits, return error message
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        // Generate a token for the user
        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => "Logged in successfully"
        ], 200);
    }

    public function logout(Request $request)
    {
        //Revoke the token for the user

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "User logged out successfully"
        ], 200);
    }
}

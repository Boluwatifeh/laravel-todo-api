<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register a new user 
    public function register(Request $request)
    {
        // Validate the request data
        $validatedData  = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        } 
        // Check if the email already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json(['message' => 'Email already exists'], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

     // Login a user
     public function login(Request $request)
     {
         $validatedData = Validator::make($request->all(), [
             'email' => 'required|string|email',
             'password' => 'required|string',
         ]);
         if ($validatedData->fails()) {
             return response()->json($validatedData->errors(), 422);
         }
         $user = User::where('email', $request->email)->first();
         if (!$user || !password_verify($request->password, $user->password)) {
             return response()->json(['message' => 'Invalid credentials'], 401);
         }
         $token = $user->createToken('Personal Access Token')->plainTextToken;
         return response()->json([
             'message' => 'User logged in successfully',
             'user' => $user,
             'token' => $token,
         ], 200);
     }

     // logout 
    public function logout (Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logged out successfully!'
        ], 200);
    }
}
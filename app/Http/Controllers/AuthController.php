<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request) {
        $validatedUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        // incorrect values
        if($validatedUser->fails()) {
            return response()->json([
                'message' => 'Oops, something went wrong, please try again',
                'error' => $validatedUser->errors()
            ], 401);
        }

        // correct values: store and return a token
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']) // hash password
        ]);

        // send over taken directly so user does not need to login after registering
        $token = $user->createToken('APITOKEN')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // Login Function
    public function login(Request $request) {
        $validatedUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        // incorrect values
        if($validatedUser->fails()) {
            return response()->json([
                'message' => 'Oops, something went wrong, please try again',
                'error' => $validatedUser->errors()
            ], 401);
        }

        // incorrect login credentials
        if(!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'invalid credentials'
            ], 401);
        }

        // correct - return access token
        $user = User::where('email', $request->email)->first();
        return response()->json([
            'message' => 'User logged in',
            'token' => $user->createToken('APITOKEN')->plainTextToken
        ], 200);


    }

    // Logout function
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $response = [
            'message' => 'User logged out'
        ];

        return response($response, 200);

    }
}

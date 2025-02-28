<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Google_Client;

class AuthController extends Controller
{
    // function for register
    public function register(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);

        // create a new user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // save the user
        $user->save();

        // return the user
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    // function for login google
    public function loginGoogle(Request $request)
    {
        // validate the request
        $request->validate([
            'id_token' => 'required|string'
        ]);

        // get the id token
        $idToken = $request->id_token;
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($idToken);

        // check if the payload is valid
        if ($payload) {
            // get the user info
            $user = User::where('email', $payload['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            // check if the user exists
            if ($user) {
                // return the user
                return response()->json([
                    'status' => 'success',
                    'message' => 'User logged in successfully',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                ]);
            } else {
                // create a new user
                $user = new User([
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'password' => Hash::make($payload['sub'])
                ]);

                // save the user
                $user->save();

                $token = $user->createToken('auth_token')->plainTextToken;

                // return the user
                return response()->json([
                    'status' => 'success',
                    'message' => 'User created and logged in successfully',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                ], 201);
            }
        } else {
            // return error
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid id token'
            ], 400);
        }

    }

    // function for login biasa
    public function login(Request $request)
    {
        // validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // get the user
        $user = User::where('email', $request->email)->first();

        // check if the user exists
        if (!$user || !Hash::check($request->password, $user->password)) {
            // return error
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        // create a token
        $token = $user->createToken('auth_token')->plainTextToken;

        // return the user
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    // function for logout
    public function logout(Request $request)
    {
        // revoke the token
        $request->user()->currentAccessToken()->delete();

        // return success
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
    }

}
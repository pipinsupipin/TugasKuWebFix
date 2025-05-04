<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle user registration request.
     *
     * @param Request $request
     * @return JsonRespxonse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Validasi request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Log registration attempt with safe data
            Log::info('Registration attempt', ['email' => $request->email]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate token
            $token = $user->createToken('TugasKu')->plainTextToken;

            // Return success response
            return response()->json([
                'message' => 'Registration successful',
                'user' => $user->only(['id', 'name', 'email', 'created_at']),
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Registration failed',
                'error' => 'An error occurred during registration'
            ], 500);
        }
    }
}
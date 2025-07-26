<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,
            ],
            'message' => 'Successfully registered',
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = auth()->user();

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status'  => true,
                'data'    => [
                    'user'        => $user,
                    'accessToken' => $token,
                ],
                'message' => 'Login Success',
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,
            ],
            'message' => 'Login Success',
        ], 200);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status'  => true,
            'data'    => [],
            'message' => 'Successfully logged out',
        ], 200);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,
            ],
            'message' => 'Password changed successfully',
        ], 200);
    }
}

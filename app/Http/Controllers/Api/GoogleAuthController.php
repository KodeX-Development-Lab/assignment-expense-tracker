<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

// https://igloo.hr/google-login-with-react-and-laravel-api/

class GoogleAuthController extends Controller
{
    public function redirectToAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function handleAuthCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var User $user */
        $user = User::query()
            ->firstOrCreate(
                [
                    'email' => $socialiteUser->getEmail(),
                ],
                [
                    'email_verified_at' => now(),
                    'name'              => $socialiteUser->getName(),
                    'google_id'         => $socialiteUser->getId(),
                    'avatar'            => $socialiteUser->getAvatar(),
                ]
            );

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status'  => true,
            'data'    => [
                'user'        => $user,
                'accessToken' => $token,
            ],
            'message' => "Successfully loginned",
        ]);
    }
}

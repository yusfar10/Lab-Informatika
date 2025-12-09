<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class RefreshTokenService
{
    /**
     * Generate a new refresh token for the user
     */
    public function generateRefreshToken(User $user): string
    {
        $refreshToken = Str::random(64);
        $expiresAt = Carbon::now()->addDays(30); // Refresh token expires in 30 days

        // Store refresh token in cache with user ID
        Cache::put(
            'refresh_token_' . $refreshToken,
            [
                'user_id' => $user->id,
                'expires_at' => $expiresAt
            ],
            $expiresAt
        );

        return $refreshToken;
    }

    /**
     * Refresh access token using refresh token
     */
    public function refreshAccessToken(string $refreshToken): string
    {
        $tokenData = Cache::get('refresh_token_' . $refreshToken);

        if (!$tokenData || Carbon::now()->greaterThan($tokenData['expires_at'])) {
            throw new \Exception('Invalid or expired refresh token');
        }

        $user = User::find($tokenData['user_id']);

        if (!$user) {
            throw new \Exception('User not found');
        }

        // Generate new access token
        $newToken = auth('api')->login($user);

        return $newToken;
    }

    /**
     * Revoke refresh token
     */
    public function revokeRefreshToken(string $refreshToken): void
    {
        Cache::forget('refresh_token_' . $refreshToken);
    }

    /**
     * Clean up expired refresh tokens (can be called by a scheduled job)
     */
    public function cleanupExpiredTokens(): void
    {
        // This would require iterating through cache keys, which is not efficient with Cache facade
        // Consider using a database table for refresh tokens in production
    }
}

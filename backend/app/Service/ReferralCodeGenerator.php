<?php

namespace App\Service;

use App\Models\User;

class ReferralCodeGenerator
{
    /**
     * Generates a random referral code.
     *
     * This method generates a random string of specified length using the provided character set.
     * It then checks for existing codes in the database and regenerates if necessary.
     *
     * @return string The generated referral code.
     * 
     * @throws \Exception If an error occurs during code generation or validation.
     */
    public function generate($name): string
    {
        // Extract the first 4 characters of the name
        $namePrefix = substr($name, 0, 5);
        // Generate a unique referral code
        do {
            $randomSuffix = strtoupper(substr(md5(uniqid()), 0, 4)); // Random 4-character suffix
            $code = $namePrefix . $randomSuffix; // Combine prefix and suffix
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Finds a user by referral code and increments their referral count in a single database query.
     *
     * This method takes a referral code as input and attempts to find a matching user in the database.
     * If a user is found, it atomically increments their `referral_count` by 1 and retrieves the user's ID.
     * 
     * This method utilizes a single database query with Laravel's `update` method and raw expressions for efficiency.
     *
     * @param string $referralCode The referral code to be checked.
     * 
     * @return int|null The user ID if found, otherwise null.
     *
     */
    public function getUserIdByReferralCodeAndIncrementCount(string $referralCode): int|null
    {
        $userId = User::where('referral_code', $referralCode)->value('id');

        if ($userId) {
            $this->incrementReferralCount($userId);
            return $userId;
        }
        return null;
    }

    private function incrementReferralCount(int $userId): void
    {
        User::where('id', $userId)->increment('referral_count');
    }
}
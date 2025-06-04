<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Service\ReferralCodeGenerator;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * The referral code generator service.
     *
     * @var ReferralCodeGenerator
     */
    protected $referralCodeGenerator;

    /**
     * Create a new controller instance.
     *
     * @param ReferralCodeGenerator $referralCodeGenerator
     */
    public function __construct(ReferralCodeGenerator $referralCodeGenerator)
    {
        $this->referralCodeGenerator = $referralCodeGenerator;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validate input data
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'city' => ['required', 'integer'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => $this->passwordRules(),
            'referral_code' => ['nullable', 'string', 'max:255'],
        ])->validateWithBag('registered');

        // Check if a referral code was provided and get the referring user
        $referredBy = null;
        if (!empty($input['referral_code'])) {
            $referredBy = $this->referralCodeGenerator->getUserIdByReferralCodeAndIncrementCount($input['referral_code']);
        }

        // Create the new user
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'city' => $input['city'],
            'password' => Hash::make($input['password']),
            'referral_code' => $this->referralCodeGenerator->generate($input['name']),
            'referred_by' => $referredBy,
        ]);
    }
}
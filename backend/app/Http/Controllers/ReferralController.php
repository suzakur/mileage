<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Service\ReferralCodeGenerator;
use App\Http\Requests\UserStoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReferralController extends Controller
{


    /**
     * fetch user referrals.
     */
    public function fetchUserReferral(User $user): JsonResponse
    {
        $referrals = User::where('referred_by', $user->id)->get();

        return response()->json([
            'message' => 'success',
            'data' => [
                'referrals_count' => $user->referral_count,
                'referrals' => $referrals
            ]
        ], Response::HTTP_OK);
    }
}

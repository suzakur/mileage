<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravelcm\Subscriptions\Models\Plan;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display subscription plans
     */
    public function index()
    {
        $plans = Plan::with('features')->active()->orderBy('sort_order')->get();
        $currentSubscription = Auth::user()->activeSubscription();
        
        return view('subscriptions.index', compact('plans', 'currentSubscription'));
    }

    /**
     * Show subscription details
     */
    public function show()
    {
        $user = Auth::user();
        $currentSubscription = $user->activeSubscription();
        $subscriptionHistory = $user->subscriptions()->with('plan')->latest()->get();
        
        return view('subscriptions.show', compact('currentSubscription', 'subscriptionHistory'));
    }

    /**
     * Subscribe to a plan
     */
    public function subscribe(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_method' => 'sometimes|string'
        ]);

        $user = Auth::user();
        
        // Cancel existing subscription if exists
        if ($user->subscribed()) {
            $user->activeSubscription()->cancel();
        }

        // Create new subscription
        $subscription = $user->newSubscription('main', $plan);
        
        // If plan has trial period, start trial
        if ($plan->trial_period > 0) {
            $trialEndsAt = Carbon::now()->add($plan->trial_interval, $plan->trial_period);
            $subscription->trialUntil($trialEndsAt);
        }

        $subscription = $subscription->create();

        return redirect()->route('subscriptions.show')
            ->with('success', 'Successfully subscribed to ' . $plan->name);
    }

    /**
     * Upgrade subscription
     */
    public function upgrade(Request $request, Plan $plan)
    {
        $user = Auth::user();
        $currentSubscription = $user->activeSubscription();

        if (!$currentSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        // Calculate prorated amount if needed
        $proratedAmount = $this->calculateProratedAmount($currentSubscription, $plan);

        // Change plan
        $currentSubscription->changePlan($plan);

        return redirect()->route('subscriptions.show')
            ->with('success', 'Successfully upgraded to ' . $plan->name . '. Prorated amount: Rp ' . number_format($proratedAmount));
    }

    /**
     * Downgrade subscription
     */
    public function downgrade(Request $request, Plan $plan)
    {
        $user = Auth::user();
        $currentSubscription = $user->activeSubscription();

        if (!$currentSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        // Schedule plan change for next billing cycle
        $currentSubscription->changePlan($plan);

        return redirect()->route('subscriptions.show')
            ->with('success', 'Your plan will be downgraded to ' . $plan->name . ' at the end of your current billing cycle.');
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        $request->validate([
            'cancellation_reason' => 'sometimes|string|max:500'
        ]);

        // Cancel at period end
        $subscription->cancel();

        return redirect()->route('subscriptions.show')
            ->with('success', 'Your subscription has been cancelled. You can continue using the service until ' . $subscription->ends_at->format('M d, Y'));
    }

    /**
     * Resume subscription
     */
    public function resume(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscription('main');

        if (!$subscription || !$subscription->cancelled()) {
            return redirect()->route('subscriptions.show')
                ->with('error', 'Cannot resume subscription.');
        }

        $subscription->resume();

        return redirect()->route('subscriptions.show')
            ->with('success', 'Your subscription has been resumed successfully.');
    }

    /**
     * Calculate prorated amount for plan changes
     */
    private function calculateProratedAmount($currentSubscription, $newPlan)
    {
        $currentPlan = $currentSubscription->plan;
        $daysRemaining = $currentSubscription->ends_at->diffInDays(Carbon::now());
        $totalDaysInPeriod = $currentSubscription->created_at->diffInDays($currentSubscription->ends_at);
        
        $unusedAmount = ($currentPlan->price * $daysRemaining) / $totalDaysInPeriod;
        $newPlanAmount = ($newPlan->price * $daysRemaining) / $totalDaysInPeriod;
        
        return max(0, $newPlanAmount - $unusedAmount);
    }

    /**
     * Get plan comparison data for frontend
     */
    public function compare()
    {
        $plans = Plan::with('features')->active()->orderBy('sort_order')->get();
        
        $comparison = $plans->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'slug' => $plan->slug,
                'price' => $plan->price,
                'currency' => $plan->currency,
                'features' => $plan->features->pluck('name', 'slug')->toArray()
            ];
        });

        return response()->json($comparison);
    }

    /**
     * Check subscription status
     */
    public function status()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription();
        
        $status = [
            'subscribed' => $user->subscribed(),
            'on_trial' => $user->onTrial(),
            'cancelled' => $subscription ? $subscription->cancelled() : false,
            'plan' => $subscription ? $subscription->plan->name : null,
            'ends_at' => $subscription ? $subscription->ends_at : null,
        ];

        return response()->json($status);
    }
}

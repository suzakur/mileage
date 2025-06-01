<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing plans and features
        DB::table('plans')->delete();
        DB::table('features')->delete();

        // Create Plans
        $basicPlanId = DB::table('plans')->insertGetId([
            'name' => json_encode(['en' => 'Gratis']),
            'slug' => 'gratis',
            'description' => json_encode(['en' => 'Perfect for getting started with credit card management']),
            'is_active' => true,
            'price' => 0.00,
            'signup_fee' => 0.00,
            'currency' => 'IDR',
            'trial_period' => 0,
            'trial_interval' => 'day',
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'grace_period' => 0,
            'grace_interval' => 'day',
            'sort_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $plusPlanId = DB::table('plans')->insertGetId([
            'name' => json_encode(['en' => 'Plus']),
            'slug' => 'plus',
            'description' => json_encode(['en' => 'Most popular plan with advanced features']),
            'is_active' => true,
            'price' => 49000.00,
            'signup_fee' => 0.00,
            'currency' => 'IDR',
            'trial_period' => 7,
            'trial_interval' => 'day',
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'grace_period' => 3,
            'grace_interval' => 'day',
            'sort_order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $proPlanId = DB::table('plans')->insertGetId([
            'name' => json_encode(['en' => 'Pro']),
            'slug' => 'pro',
            'description' => json_encode(['en' => 'Perfect for power users']),
            'is_active' => true,
            'price' => 99000.00,
            'signup_fee' => 0.00,
            'currency' => 'IDR',
            'trial_period' => 14,
            'trial_interval' => 'day',
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'grace_period' => 7,
            'grace_interval' => 'day',
            'sort_order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $businessPlanId = DB::table('plans')->insertGetId([
            'name' => json_encode(['en' => 'Bisnis']),
            'slug' => 'bisnis',
            'description' => json_encode(['en' => 'Custom solution for large organizations']),
            'is_active' => true,
            'price' => 199000.00,
            'signup_fee' => 0.00,
            'currency' => 'IDR',
            'trial_period' => 30,
            'trial_interval' => 'day',
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'grace_period' => 30,
            'grace_interval' => 'day',
            'sort_order' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Features for Basic Plan
        DB::table('features')->insert([
            [
                'plan_id' => $basicPlanId,
                'name' => json_encode(['en' => 'Credit Cards']),
                'slug' => 'credit_cards',
                'description' => json_encode(['en' => 'Number of credit cards']),
                'value' => '2',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $basicPlanId,
                'name' => json_encode(['en' => 'Analytics']),
                'slug' => 'analytics',
                'description' => json_encode(['en' => 'Basic analytics']),
                'value' => 'Basic',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $basicPlanId,
                'name' => json_encode(['en' => 'Support']),
                'slug' => 'support',
                'description' => json_encode(['en' => 'Email support']),
                'value' => 'Email',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create Features for Plus Plan
        DB::table('features')->insert([
            [
                'plan_id' => $plusPlanId,
                'name' => json_encode(['en' => 'Credit Cards']),
                'slug' => 'credit_cards',
                'description' => json_encode(['en' => 'Number of credit cards']),
                'value' => '10',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $plusPlanId,
                'name' => json_encode(['en' => 'Analytics']),
                'slug' => 'analytics',
                'description' => json_encode(['en' => 'Advanced analytics']),
                'value' => 'Advanced',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $plusPlanId,
                'name' => json_encode(['en' => 'AI Recommendations']),
                'slug' => 'ai_recommendations',
                'description' => json_encode(['en' => 'AI-powered recommendations']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $plusPlanId,
                'name' => json_encode(['en' => 'Support']),
                'slug' => 'support',
                'description' => json_encode(['en' => 'Priority support']),
                'value' => 'Priority',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create Features for Pro Plan
        DB::table('features')->insert([
            [
                'plan_id' => $proPlanId,
                'name' => json_encode(['en' => 'Credit Cards']),
                'slug' => 'credit_cards',
                'description' => json_encode(['en' => 'Number of credit cards']),
                'value' => 'Unlimited',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $proPlanId,
                'name' => json_encode(['en' => 'Analytics']),
                'slug' => 'analytics',
                'description' => json_encode(['en' => 'Advanced analytics']),
                'value' => 'Advanced',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $proPlanId,
                'name' => json_encode(['en' => 'AI Recommendations']),
                'slug' => 'ai_recommendations',
                'description' => json_encode(['en' => 'AI-powered recommendations']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $proPlanId,
                'name' => json_encode(['en' => 'Auto Payment']),
                'slug' => 'auto_payment',
                'description' => json_encode(['en' => 'Automatic payment scheduling']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $proPlanId,
                'name' => json_encode(['en' => 'Support']),
                'slug' => 'support',
                'description' => json_encode(['en' => 'Priority support']),
                'value' => 'Priority',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create Features for Business Plan
        DB::table('features')->insert([
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'Credit Cards']),
                'slug' => 'credit_cards',
                'description' => json_encode(['en' => 'Number of credit cards']),
                'value' => 'Unlimited',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'Analytics']),
                'slug' => 'analytics',
                'description' => json_encode(['en' => 'Advanced analytics']),
                'value' => 'Advanced',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'AI Recommendations']),
                'slug' => 'ai_recommendations',
                'description' => json_encode(['en' => 'AI-powered recommendations']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'Auto Payment']),
                'slug' => 'auto_payment',
                'description' => json_encode(['en' => 'Automatic payment scheduling']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'Multi-user Access']),
                'slug' => 'multi_user',
                'description' => json_encode(['en' => 'Team collaboration']),
                'value' => 'Yes',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $businessPlanId,
                'name' => json_encode(['en' => 'Support']),
                'slug' => 'support',
                'description' => json_encode(['en' => 'Dedicated support']),
                'value' => 'Dedicated',
                'resettable_period' => 0,
                'resettable_interval' => 'month',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        echo "Subscription plans and features created successfully!\n";
    }
}

@extends('layouts.app')

@section('title', 'Subscription Plans - Mileage')

@section('styles')
<style>
    .subscription-hero {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .subscription-hero h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .subscription-hero p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .plan-card {
        background: var(--card-color);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .plan-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-color);
        box-shadow: 0 20px 40px var(--shadow);
    }

    .plan-card.current-plan {
        border-color: var(--primary-color);
        box-shadow: 0 15px 35px rgba(63, 76, 255, 0.2);
    }

    .plan-card.current-plan::before {
        content: 'CURRENT PLAN';
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--primary-color);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .plan-card.popular {
        border-color: var(--primary-color);
        transform: scale(1.05);
        box-shadow: 0 15px 35px var(--shadow);
    }

    .plan-card.popular::before {
        content: 'MOST POPULAR';
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .plan-name {
        color: var(--text-primary);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .plan-price {
        color: var(--primary-color);
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }

    .plan-price .currency {
        font-size: 1rem;
        font-weight: 500;
    }

    .plan-period {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .plan-features {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
        flex-grow: 1;
    }

    .plan-features li {
        padding: 0.5rem 0;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .plan-features li i {
        color: var(--primary-color);
        font-size: 1rem;
        width: 16px;
    }

    .plan-action {
        margin-top: auto;
        padding-top: 1.5rem;
    }

    .btn-subscribe {
        width: 100%;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-subscribe.primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-subscribe.primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(63, 76, 255, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-subscribe.outline {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn-subscribe.outline:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    .btn-subscribe.current {
        background: var(--border-color);
        color: var(--text-secondary);
        cursor: not-allowed;
    }

    .current-subscription-alert {
        background: rgba(63, 76, 255, 0.1);
        border: 1px solid var(--primary-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        color: var(--text-primary);
    }

    .comparison-table {
        margin-top: 4rem;
        background: var(--card-color);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .comparison-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .comparison-table th,
    .comparison-table td {
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
    }

    .comparison-table th {
        background: var(--surface-color);
        color: var(--text-primary);
        font-weight: 600;
    }

    .comparison-table td {
        color: var(--text-secondary);
    }

    .feature-check {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .feature-cross {
        color: #dc3545;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .subscription-hero h1 {
            font-size: 2rem;
        }
        
        .plan-card.popular {
            transform: scale(1);
        }
        
        .plan-price {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="subscription-hero text-center">
    <div class="container">
        <h1>Choose Your Perfect Plan</h1>
        <p>Select the subscription plan that best fits your credit card management needs. Upgrade or downgrade anytime.</p>
    </div>
</div>

<div class="container">
    @if($currentSubscription)
    <div class="current-subscription-alert">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="mb-1">Current Plan: {{ $currentSubscription->plan->name }}</h6>
                <p class="mb-0 small">
                    @if($currentSubscription->cancelled())
                        <span class="text-warning">Cancelled - expires on {{ $currentSubscription->ends_at->format('M d, Y') }}</span>
                    @elseif($currentSubscription->onTrial())
                        <span class="text-info">Trial period - expires on {{ $currentSubscription->trial_ends_at->format('M d, Y') }}</span>
                    @else
                        Next billing: {{ $currentSubscription->ends_at->format('M d, Y') }}
                    @endif
                </p>
            </div>
            <a href="{{ route('subscriptions.show') }}" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
    </div>
    @endif

    <div class="row g-4">
        @foreach($plans as $index => $plan)
        <div class="col-lg-3 col-md-6">
            <div class="plan-card {{ $index === 1 ? 'popular' : '' }} {{ $currentSubscription && $currentSubscription->plan_id === $plan->id ? 'current-plan' : '' }}">
                <div class="plan-name">{{ $plan->name }}</div>
                <div class="plan-price">
                    @if($plan->price > 0)
                        <span class="currency">Rp</span>{{ number_format($plan->price, 0) }}
                    @else
                        Free
                    @endif
                </div>
                <div class="plan-period">
                    @if($plan->price > 0)
                        per {{ $plan->invoice_interval }}
                    @else
                        forever
                    @endif
                </div>

                <ul class="plan-features">
                    @foreach($plan->features as $feature)
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ $feature->name }}: {{ $feature->pivot->value }}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="plan-action">
                    @if($currentSubscription && $currentSubscription->plan_id === $plan->id)
                        <button class="btn-subscribe current">Current Plan</button>
                    @elseif($currentSubscription)
                        @if($plan->price > $currentSubscription->plan->price)
                            <form action="{{ route('subscriptions.upgrade', $plan) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-subscribe primary">Upgrade</button>
                            </form>
                        @elseif($plan->price < $currentSubscription->plan->price)
                            <form action="{{ route('subscriptions.downgrade', $plan) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-subscribe outline">Downgrade</button>
                            </form>
                        @endif
                    @else
                        <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-subscribe primary">
                                @if($plan->trial_period > 0)
                                    Start {{ $plan->trial_period }}-day Trial
                                @elseif($plan->price > 0)
                                    Subscribe Now
                                @else
                                    Get Started Free
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Feature Comparison Table -->
    <div class="comparison-table">
        <table>
            <thead>
                <tr>
                    <th>Features</th>
                    @foreach($plans as $plan)
                    <th>{{ $plan->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $allFeatures = $plans->flatMap->features->unique('slug');
                @endphp
                @foreach($allFeatures as $feature)
                <tr>
                    <td class="text-start"><strong>{{ $feature->name }}</strong></td>
                    @foreach($plans as $plan)
                        @php
                            $planFeature = $plan->features->where('slug', $feature->slug)->first();
                        @endphp
                        <td>
                            @if($planFeature)
                                @if($planFeature->pivot->value === 'Y')
                                    <i class="bi bi-check-circle-fill feature-check"></i>
                                @elseif($planFeature->pivot->value === 'N')
                                    <i class="bi bi-x-circle-fill feature-cross"></i>
                                @else
                                    {{ $planFeature->pivot->value }}
                                @endif
                            @else
                                <i class="bi bi-x-circle-fill feature-cross"></i>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to subscription buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                if (button) {
                    button.disabled = true;
                    button.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                }
            });
        });

        // Add confirmation for downgrades and cancellations
        document.querySelectorAll('form[action*="downgrade"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to downgrade your plan? The change will take effect at the end of your current billing cycle.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection 
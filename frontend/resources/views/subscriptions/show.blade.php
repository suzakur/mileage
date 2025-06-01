@extends('layouts.app')

@section('title', 'My Subscription - Mileage')

@section('styles')
<style>
    .subscription-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 16px;
        color: white;
        text-align: center;
    }

    .subscription-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px var(--shadow);
    }

    .current-plan-badge {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .plan-details h3 {
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .plan-price {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .subscription-status {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .status-active {
        background: rgba(80, 205, 137, 0.1);
        border: 1px solid #50CD89;
        color: #50CD89;
    }

    .status-trial {
        background: rgba(255, 199, 0, 0.1);
        border: 1px solid #FFC700;
        color: #FFC700;
    }

    .status-cancelled {
        background: rgba(241, 65, 108, 0.1);
        border: 1px solid #F1416C;
        color: #F1416C;
    }

    .subscription-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary-action {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary-action:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .btn-outline-action {
        background: transparent;
        border: 2px solid var(--border-color);
        color: var(--text-primary);
    }

    .btn-outline-action:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        text-decoration: none;
    }

    .btn-danger-action {
        background: #F1416C;
        color: white;
    }

    .btn-danger-action:hover {
        background: #dc3545;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .subscription-history {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
    }

    .history-header {
        background: var(--surface-color);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .history-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .history-item:last-child {
        border-bottom: none;
    }

    .no-subscription {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .subscription-actions {
            flex-direction: column;
        }
        
        .btn-action {
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container" style="padding-top: 100px;">
    <div class="subscription-header">
        <h1>My Subscription</h1>
        <p>Manage your subscription plan and billing information</p>
    </div>

    @if($currentSubscription)
    <div class="subscription-card">
        <div class="current-plan-badge">CURRENT PLAN</div>
        
        <div class="plan-details">
            <h3>{{ $currentSubscription->plan->name ?? 'Unknown Plan' }}</h3>
            <div class="plan-price">
                @if($currentSubscription->plan && $currentSubscription->plan->price > 0)
                    Rp {{ number_format($currentSubscription->plan->price, 0) }}
                    <small style="font-size: 1rem; font-weight: 400;">/ {{ $currentSubscription->plan->invoice_interval ?? 'month' }}</small>
                @else
                    Free
                @endif
            </div>
        </div>

        <div class="subscription-status {{ $currentSubscription->cancelled() ? 'status-cancelled' : ($currentSubscription->onTrial() ? 'status-trial' : 'status-active') }}">
            @if($currentSubscription->cancelled())
                <strong>Cancelled</strong> - Your subscription will expire on {{ $currentSubscription->ends_at->format('M d, Y') }}
            @elseif($currentSubscription->onTrial())
                <strong>Trial Period</strong> - Your trial expires on {{ $currentSubscription->trial_ends_at->format('M d, Y') }}
            @else
                <strong>Active</strong> - Next billing date: {{ $currentSubscription->ends_at->format('M d, Y') }}
            @endif
        </div>

        <div class="subscription-actions">
            @if($currentSubscription->cancelled())
                <form action="{{ route('subscriptions.resume') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-action btn-primary-action">Resume Subscription</button>
                </form>
            @else
                <a href="{{ route('subscriptions.index') }}" class="btn-action btn-outline-action">Change Plan</a>
                
                <button type="button" class="btn-action btn-danger-action" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    Cancel Subscription
                </button>
            @endif
        </div>
    </div>

    <!-- Features List -->
    @if($currentSubscription->plan && $currentSubscription->plan->features)
    <div class="subscription-card">
        <h4 style="color: var(--text-primary); margin-bottom: 1.5rem;">Your Plan Features</h4>
        <div class="row">
            @foreach($currentSubscription->plan->features as $feature)
            <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-3"></i>
                    <div>
                        <strong style="color: var(--text-primary);">{{ $feature->name ?? 'Feature' }}</strong>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">{{ $feature->value ?? 'Included' }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    <div class="subscription-card no-subscription">
        <i class="bi bi-credit-card fs-1 text-muted mb-3"></i>
        <h3 style="color: var(--text-primary);">No Active Subscription</h3>
        <p>You don't have an active subscription. Choose a plan to get started!</p>
        <a href="{{ route('subscriptions.index') }}" class="btn-action btn-primary-action">View Plans</a>
    </div>
    @endif

    <!-- Subscription History -->
    @if($subscriptionHistory && count($subscriptionHistory) > 0)
    <div class="subscription-history">
        <div class="history-header">
            <h4 style="color: var(--text-primary); margin: 0;">Subscription History</h4>
        </div>
        @foreach($subscriptionHistory as $subscription)
        <div class="history-item">
            <div>
                <strong style="color: var(--text-primary);">{{ $subscription->plan->name ?? 'Unknown Plan' }}</strong>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">
                    {{ $subscription->created_at->format('M d, Y') }} - 
                    @if($subscription->ends_at)
                        {{ $subscription->ends_at->format('M d, Y') }}
                    @else
                        Present
                    @endif
                </div>
            </div>
            <div style="color: var(--text-secondary);">
                @if($subscription->cancelled())
                    <span class="badge bg-danger">Cancelled</span>
                @elseif($subscription->onTrial())
                    <span class="badge bg-warning">Trial</span>
                @else
                    <span class="badge bg-success">Active</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Cancel Subscription Modal -->
@if($currentSubscription && !$currentSubscription->cancelled())
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--card-color); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="cancelModalLabel" style="color: var(--text-primary);">Cancel Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('subscriptions.cancel') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="color: var(--text-secondary);">Are you sure you want to cancel your subscription? You'll continue to have access until {{ $currentSubscription->ends_at->format('M d, Y') }}.</p>
                    
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label" style="color: var(--text-primary);">Reason for cancellation (optional)</label>
                        <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" 
                                  style="background: var(--surface-color); border-color: var(--border-color); color: var(--text-primary);"
                                  placeholder="Help us improve by telling us why you're cancelling..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Subscription</button>
                    <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for subscription actions
        document.querySelectorAll('form[action*="cancel"], form[action*="resume"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const action = this.action.includes('cancel') ? 'cancel' : 'resume';
                const message = action === 'cancel' 
                    ? 'Are you sure you want to cancel your subscription?' 
                    : 'Are you sure you want to resume your subscription?';
                
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });

        // Add loading state to buttons
        document.querySelectorAll('form button[type="submit"]').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                form.addEventListener('submit', function() {
                    button.disabled = true;
                    button.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                });
            });
        });
    });
</script>
@endsection 
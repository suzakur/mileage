@extends('layouts.app')

@section('title', 'Challenges - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px;
        padding-bottom: 3rem;
    }
    .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .page-header h1 {
        font-size: 2.8rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .page-header p {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 700px;
        margin: 0 auto;
    }

    /* Challenge Stats */
    .challenge-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 20px var(--shadow);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Challenge Tabs */
    .challenge-tabs {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px var(--shadow);
    }
    .nav-pills .nav-link {
        border-radius: 8px;
        color: var(--text-secondary);
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background: var(--primary-color);
        color: white;
    }
    .nav-pills .nav-link:hover:not(.active) {
        background: var(--surface-color);
        border-color: var(--border-color);
    }

    /* Challenge Cards */
    .challenge-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 20px var(--shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .challenge-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px var(--shadow);
    }
    .challenge-card.completed {
        border-color: var(--success-color);
        background: linear-gradient(135deg, var(--card-color) 0%, rgba(40, 167, 69, 0.1) 100%);
    }
    .challenge-card.locked {
        opacity: 0.6;
        background: var(--surface-color);
    }

    .challenge-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .challenge-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
    }
    .challenge-info {
        flex: 1;
    }
    .challenge-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .challenge-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .challenge-reward {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Progress Bar */
    .challenge-progress {
        margin-bottom: 1rem;
    }
    .progress-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .progress-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .progress-percentage {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
    }
    .progress {
        height: 8px;
        background: var(--surface-color);
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-bar {
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transition: width 0.3s ease;
    }

    /* Challenge Actions */
    .challenge-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .challenge-status {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-active {
        background: rgba(63, 76, 255, 0.1);
        color: var(--primary-color);
    }
    .status-completed {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }
    .status-locked {
        background: rgba(108, 117, 125, 0.1);
        color: var(--text-secondary);
    }

    /* Leaderboard */
    .leaderboard-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px var(--shadow);
    }
    .leaderboard-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.3s ease;
    }
    .leaderboard-item:last-child {
        border-bottom: none;
    }
    .leaderboard-item:hover {
        background: var(--surface-color);
        border-radius: 8px;
        margin: 0 -0.5rem;
        padding: 0.75rem 0.5rem;
    }
    .leaderboard-rank {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 1rem;
    }
    .rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: white; }
    .rank-2 { background: linear-gradient(135deg, #C0C0C0, #A0A0A0); color: white; }
    .rank-3 { background: linear-gradient(135deg, #CD7F32, #B8860B); color: white; }
    .rank-other { background: var(--surface-color); color: var(--text-secondary); }
    .leaderboard-user {
        flex: 1;
    }
    .leaderboard-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    .leaderboard-score {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .leaderboard-points {
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Achievement Badges */
    .achievement-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .achievement-badge {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .achievement-badge:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px var(--shadow);
    }
    .achievement-badge.earned {
        border-color: var(--success-color);
        background: linear-gradient(135deg, var(--card-color) 0%, rgba(40, 167, 69, 0.1) 100%);
    }
    .achievement-badge.locked {
        opacity: 0.4;
    }
    .achievement-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1.2rem;
        color: white;
    }
    .achievement-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    .achievement-description {
        font-size: 0.7rem;
        color: var(--text-secondary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .challenge-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .challenge-icon {
            margin-bottom: 1rem;
        }
        .challenge-actions {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Challenges & Achievements</h1>
        <p>Complete spending challenges, earn rewards, and unlock exclusive achievements. Track your progress and compete with other users!</p>
    </div>

    {{-- Challenge Statistics --}}
    <div class="challenge-stats">
        <div class="stat-card">
            <div class="stat-number" id="activeCount">3</div>
            <div class="stat-label">Active Challenges</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="completedCount">12</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalPoints">2,450</div>
            <div class="stat-label">Total Points</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="currentRank">#47</div>
            <div class="stat-label">Current Rank</div>
        </div>
    </div>

    {{-- Challenge Tabs --}}
    <div class="challenge-tabs">
        <ul class="nav nav-pills justify-content-center" id="challengeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-bs-toggle="pill" data-bs-target="#active" type="button" role="tab">
                    <i class="bi bi-play-circle me-1"></i>Active Challenges
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                    <i class="bi bi-check-circle me-1"></i>Completed
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="achievements-tab" data-bs-toggle="pill" data-bs-target="#achievements" type="button" role="tab">
                    <i class="bi bi-trophy me-1"></i>Achievements
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="leaderboard-tab" data-bs-toggle="pill" data-bs-target="#leaderboard" type="button" role="tab">
                    <i class="bi bi-bar-chart me-1"></i>Leaderboard
                </button>
            </li>
        </ul>
    </div>

    {{-- Tab Content --}}
    <div class="tab-content" id="challengeTabContent">
        {{-- Active Challenges --}}
        <div class="tab-pane fade show active" id="active" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    {{-- Monthly Spending Challenge --}}
                    <div class="challenge-card">
                        <div class="challenge-header">
                            <div class="d-flex">
                                <div class="challenge-icon" style="background: linear-gradient(135deg, #3F4CFF, #A14FFF);">
                                    <i class="bi bi-calendar-month"></i>
                                </div>
                                <div class="challenge-info">
                                    <div class="challenge-title">Monthly Spending Challenge</div>
                                    <div class="challenge-description">Spend Rp 5,000,000 this month using your credit cards to unlock exclusive rewards and bonus points.</div>
                                </div>
                            </div>
                            <div class="challenge-reward">
                                <i class="bi bi-star-fill"></i>500 Points
                            </div>
                        </div>
                        <div class="challenge-progress">
                            <div class="progress-info">
                                <span class="progress-text">Rp 3,250,000 / Rp 5,000,000</span>
                                <span class="progress-percentage">65%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="challenge-actions">
                            <span class="challenge-status status-active">Active</span>
                            <small class="text-muted">Ends in 12 days</small>
                        </div>
                    </div>

                    {{-- Travel Rewards Challenge --}}
                    <div class="challenge-card">
                        <div class="challenge-header">
                            <div class="d-flex">
                                <div class="challenge-icon" style="background: linear-gradient(135deg, #28A745, #20C997);">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <div class="challenge-info">
                                    <div class="challenge-title">Travel Rewards Collector</div>
                                    <div class="challenge-description">Make 3 travel-related transactions (hotels, flights, or travel agencies) to earn bonus miles.</div>
                                </div>
                            </div>
                            <div class="challenge-reward">
                                <i class="bi bi-geo-alt-fill"></i>1,000 Miles
                            </div>
                        </div>
                        <div class="challenge-progress">
                            <div class="progress-info">
                                <span class="progress-text">2 / 3 transactions</span>
                                <span class="progress-percentage">67%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 67%"></div>
                            </div>
                        </div>
                        <div class="challenge-actions">
                            <span class="challenge-status status-active">Active</span>
                            <small class="text-muted">Ends in 25 days</small>
                        </div>
                    </div>

                    {{-- Dining Challenge --}}
                    <div class="challenge-card">
                        <div class="challenge-header">
                            <div class="d-flex">
                                <div class="challenge-icon" style="background: linear-gradient(135deg, #FD7E14, #E83E8C);">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                <div class="challenge-info">
                                    <div class="challenge-title">Foodie Explorer</div>
                                    <div class="challenge-description">Spend Rp 1,500,000 on dining and restaurants to unlock cashback rewards.</div>
                                </div>
                            </div>
                            <div class="challenge-reward">
                                <i class="bi bi-cash-coin"></i>5% Cashback
                            </div>
                        </div>
                        <div class="challenge-progress">
                            <div class="progress-info">
                                <span class="progress-text">Rp 450,000 / Rp 1,500,000</span>
                                <span class="progress-percentage">30%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 30%"></div>
                            </div>
                        </div>
                        <div class="challenge-actions">
                            <span class="challenge-status status-active">Active</span>
                            <small class="text-muted">Ends in 18 days</small>
                        </div>
                    </div>

                    {{-- Locked Challenge --}}
                    <div class="challenge-card locked">
                        <div class="challenge-header">
                            <div class="d-flex">
                                <div class="challenge-icon" style="background: #6C757D;">
                                    <i class="bi bi-lock"></i>
                                </div>
                                <div class="challenge-info">
                                    <div class="challenge-title">Premium Spender</div>
                                    <div class="challenge-description">Unlock by completing the Monthly Spending Challenge. Spend Rp 10,000,000 in premium categories.</div>
                                </div>
                            </div>
                            <div class="challenge-reward">
                                <i class="bi bi-gem"></i>Premium Badge
                            </div>
                        </div>
                        <div class="challenge-actions">
                            <span class="challenge-status status-locked">Locked</span>
                            <small class="text-muted">Complete Monthly Challenge to unlock</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Quick Stats --}}
                    <div class="leaderboard-card mb-3">
                        <div class="leaderboard-header">
                            <i class="bi bi-speedometer2"></i>
                            <h5 class="mb-0">Your Progress</h5>
                        </div>
                        <div class="text-center">
                            <div class="stat-number" style="font-size: 1.5rem;">87%</div>
                            <div class="stat-label">Average Completion Rate</div>
                            <div class="mt-3">
                                <small class="text-muted">You're doing great! Keep up the momentum.</small>
                            </div>
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="leaderboard-card">
                        <div class="leaderboard-header">
                            <i class="bi bi-lightbulb"></i>
                            <h5 class="mb-0">Pro Tips</h5>
                        </div>
                        <div class="small text-muted">
                            <div class="mb-2">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                Use different cards for different categories to maximize rewards
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                Check challenge progress daily to stay on track
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                Complete easier challenges first to build momentum
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Challenges --}}
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="row">
                @for($i = 1; $i <= 6; $i++)
                <div class="col-lg-6">
                    <div class="challenge-card completed">
                        <div class="challenge-header">
                            <div class="d-flex">
                                <div class="challenge-icon" style="background: linear-gradient(135deg, #28A745, #20C997);">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="challenge-info">
                                    <div class="challenge-title">{{ ['Shopping Spree', 'Gas Station Hero', 'Online Shopping Master', 'Weekend Warrior', 'Cashback Collector', 'Miles Accumulator'][$i-1] }}</div>
                                    <div class="challenge-description">Successfully completed on {{ date('d M Y', strtotime('-'.rand(1, 30).' days')) }}</div>
                                </div>
                            </div>
                            <div class="challenge-reward">
                                <i class="bi bi-star-fill"></i>{{ rand(100, 500) }} Points
                            </div>
                        </div>
                        <div class="challenge-actions">
                            <span class="challenge-status status-completed">Completed</span>
                            <small class="text-success">Reward claimed</small>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- Achievements --}}
        <div class="tab-pane fade" id="achievements" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <h5 class="mb-3">Your Achievements</h5>
                    <div class="achievement-grid">
                        {{-- Earned Achievements --}}
                        <div class="achievement-badge earned">
                            <div class="achievement-icon" style="background: linear-gradient(135deg, #FFD700, #FFA500);">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="achievement-name">First Steps</div>
                            <div class="achievement-description">Complete your first challenge</div>
                        </div>
                        <div class="achievement-badge earned">
                            <div class="achievement-icon" style="background: linear-gradient(135deg, #3F4CFF, #A14FFF);">
                                <i class="bi bi-credit-card-fill"></i>
                            </div>
                            <div class="achievement-name">Card Master</div>
                            <div class="achievement-description">Add 3 credit cards</div>
                        </div>
                        <div class="achievement-badge earned">
                            <div class="achievement-icon" style="background: linear-gradient(135deg, #28A745, #20C997);">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="achievement-name">Cashback King</div>
                            <div class="achievement-description">Earn Rp 100,000 in cashback</div>
                        </div>
                        <div class="achievement-badge earned">
                            <div class="achievement-icon" style="background: linear-gradient(135deg, #FD7E14, #E83E8C);">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="achievement-name">Monthly Hero</div>
                            <div class="achievement-description">Complete monthly challenge</div>
                        </div>

                        {{-- Locked Achievements --}}
                        <div class="achievement-badge locked">
                            <div class="achievement-icon" style="background: #6C757D;">
                                <i class="bi bi-lock"></i>
                            </div>
                            <div class="achievement-name">Platinum Status</div>
                            <div class="achievement-description">Spend Rp 50,000,000</div>
                        </div>
                        <div class="achievement-badge locked">
                            <div class="achievement-icon" style="background: #6C757D;">
                                <i class="bi bi-lock"></i>
                            </div>
                            <div class="achievement-name">Travel Expert</div>
                            <div class="achievement-description">Earn 10,000 miles</div>
                        </div>
                        <div class="achievement-badge locked">
                            <div class="achievement-icon" style="background: #6C757D;">
                                <i class="bi bi-lock"></i>
                            </div>
                            <div class="achievement-name">Challenge Master</div>
                            <div class="achievement-description">Complete 50 challenges</div>
                        </div>
                        <div class="achievement-badge locked">
                            <div class="achievement-icon" style="background: #6C757D;">
                                <i class="bi bi-lock"></i>
                            </div>
                            <div class="achievement-name">Leaderboard Legend</div>
                            <div class="achievement-description">Reach top 10 ranking</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="leaderboard-card">
                        <div class="leaderboard-header">
                            <i class="bi bi-trophy"></i>
                            <h5 class="mb-0">Achievement Progress</h5>
                        </div>
                        <div class="text-center">
                            <div class="stat-number" style="font-size: 1.5rem;">4/12</div>
                            <div class="stat-label">Achievements Unlocked</div>
                            <div class="progress mt-3">
                                <div class="progress-bar" style="width: 33%"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">33% Complete</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Leaderboard --}}
        <div class="tab-pane fade" id="leaderboard" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <div class="leaderboard-card">
                        <div class="leaderboard-header">
                            <i class="bi bi-trophy"></i>
                            <h5 class="mb-0">Monthly Leaderboard</h5>
                        </div>
                        @php
                            $leaderboardData = [
                                ['name' => 'Ahmad Rizki', 'points' => 4850, 'challenges' => 15],
                                ['name' => 'Sarah Putri', 'points' => 4720, 'challenges' => 14],
                                ['name' => 'Budi Santoso', 'points' => 4650, 'challenges' => 13],
                                ['name' => 'Maya Sari', 'points' => 4200, 'challenges' => 12],
                                ['name' => 'Doni Pratama', 'points' => 3980, 'challenges' => 11],
                                ['name' => 'Lisa Wijaya', 'points' => 3750, 'challenges' => 10],
                                ['name' => 'Andi Kurniawan', 'points' => 3500, 'challenges' => 9],
                                ['name' => 'Rina Dewi', 'points' => 3250, 'challenges' => 8],
                                ['name' => 'Fajar Nugroho', 'points' => 3100, 'challenges' => 8],
                                ['name' => 'You', 'points' => 2450, 'challenges' => 7]
                            ];
                        @endphp
                        @foreach($leaderboardData as $index => $user)
                        <div class="leaderboard-item {{ $user['name'] === 'You' ? 'bg-primary bg-opacity-10' : '' }}">
                            <div class="leaderboard-rank {{ $index < 3 ? 'rank-'.($index+1) : 'rank-other' }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="leaderboard-user">
                                <div class="leaderboard-name">{{ $user['name'] }}</div>
                                <div class="leaderboard-score">{{ $user['challenges'] }} challenges completed</div>
                            </div>
                            <div class="leaderboard-points">{{ number_format($user['points']) }} pts</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="leaderboard-card mb-3">
                        <div class="leaderboard-header">
                            <i class="bi bi-calendar-week"></i>
                            <h5 class="mb-0">This Week</h5>
                        </div>
                        <div class="text-center">
                            <div class="stat-number" style="font-size: 1.5rem;">+350</div>
                            <div class="stat-label">Points Earned</div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +5 positions
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="leaderboard-card">
                        <div class="leaderboard-header">
                            <i class="bi bi-target"></i>
                            <h5 class="mb-0">Next Goal</h5>
                        </div>
                        <div class="text-center">
                            <div class="stat-number" style="font-size: 1.2rem;">650 pts</div>
                            <div class="stat-label">To reach #9</div>
                            <div class="progress mt-3">
                                <div class="progress-bar" style="width: 75%"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">You're getting closer!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars when they come into view
    const progressBars = document.querySelectorAll('.progress-bar');
    
    const animateProgressBars = () => {
        progressBars.forEach(bar => {
            const rect = bar.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            }
        });
    };

    // Animate on load
    setTimeout(animateProgressBars, 500);

    // Animate on scroll
    window.addEventListener('scroll', animateProgressBars);

    // Tab switching animations
    const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function() {
            const targetPane = document.querySelector(this.getAttribute('data-bs-target'));
            targetPane.style.opacity = '0';
            targetPane.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                targetPane.style.transition = 'all 0.3s ease';
                targetPane.style.opacity = '1';
                targetPane.style.transform = 'translateY(0)';
            }, 50);
        });
    });

    // Achievement badge hover effects
    const achievementBadges = document.querySelectorAll('.achievement-badge');
    achievementBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            if (!this.classList.contains('locked')) {
                this.style.transform = 'translateY(-5px) scale(1.05)';
            }
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Challenge card interactions
    const challengeCards = document.querySelectorAll('.challenge-card:not(.locked)');
    challengeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add click effect
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Simulate real-time updates (for demo purposes)
    setInterval(() => {
        const activeProgressBars = document.querySelectorAll('#active .progress-bar');
        activeProgressBars.forEach(bar => {
            const currentWidth = parseInt(bar.style.width);
            if (currentWidth < 100 && Math.random() > 0.8) {
                const newWidth = Math.min(currentWidth + 1, 100);
                bar.style.width = newWidth + '%';
                
                // Update percentage text
                const percentageElement = bar.closest('.challenge-progress').querySelector('.progress-percentage');
                if (percentageElement) {
                    percentageElement.textContent = newWidth + '%';
                }
            }
        });
    }, 5000);

    // Add confetti effect for completed challenges (placeholder)
    function showConfetti() {
        // This would integrate with a confetti library
        console.log('🎉 Challenge completed! Confetti effect would show here.');
    }

    // Leaderboard position change animation
    const userRow = document.querySelector('.leaderboard-item.bg-primary');
    if (userRow) {
        userRow.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        userRow.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
});
</script>
@endsection 
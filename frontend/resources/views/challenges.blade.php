@extends('layouts.app')

@section('title', 'Challenges - Mileage')

@section('styles')
<style>
    .page-header {
        background-color: var(--surface-color);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
    }
    .page-header h1 {
        color: var(--text-primary);
    }
    .content-wrapper {
        padding-top: 80px; /* Adjust based on header height */
        min-height: calc(100vh - 150px); /* Adjust footer height */
    }
    .challenges-placeholder {
        text-align: center;
        padding: 3rem;
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        background-color: var(--surface-color);
        margin-top: 2rem;
    }
    .challenges-placeholder h3 {
        color: var(--text-primary);
    }
    .challenges-placeholder p {
        color: var(--text-secondary);
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="container">
            <h1>Challenges</h1>
            <p class="lead text-secondary">Track your progress and earn rewards!</p>
        </div>
    </div>

    <div class="container" id="kt_content_container">
        <div class="challenges-placeholder">
            <i class="ki-duotone ki-trophy fs-3x text-warning mb-5">
                <span class="path1"></span>
                <span class="path2"></span>
                 <span class="path3"></span>
            </i>
            <h3>Challenges Page Coming Soon!</h3>
            <p>Engage in exciting spending challenges and unlock exclusive rewards.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any page-specific JavaScript here if needed
</script>
@endsection 
@extends('layouts.app')

@section('title', 'Register - Mileage')

@section('styles')
<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 120px 20px 40px;
        background: radial-gradient(ellipse at center, rgba(63, 76, 255, 0.1) 0%, transparent 70%);
    }
    
    .register-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 2.5rem; /* Slightly less padding than login */
        width: 100%;
        max-width: 480px; /* Slightly wider for more fields */
        box-shadow: 0 20px 60px var(--shadow);
        backdrop-filter: blur(20px);
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .register-header h1 {
        color: var(--text-primary);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .register-header p {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(63, 76, 255, 0.1);
        background: var(--card-color);
    }
    
    .form-input::placeholder {
        color: var(--text-secondary);
        opacity: 0.7;
    }
    
    .register-button {
        width: 100%;
        padding: 0.9rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .register-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(63, 76, 255, 0.25);
    }
    
    .login-link {
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.85rem;
    }
    
    .login-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .login-link a:hover {
        color: var(--secondary-color);
    }
    
    /* Responsive */
    @media (max-width: 480px) {
        .register-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .register-header h1 {
            font-size: 1.6rem;
        }
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card fade-in">
        <div class="register-header">
            <h1>Create Your Account</h1>
            <p>Join Mileage and start managing your cards smarter.</p>
        </div>
        
        {{-- Placeholder for error messages --}}
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        
        <form method="POST" action="{{ route('register') }}"> {{-- Assuming this route will be defined --}}
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Create a password" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Confirm your password" required>
            </div>
            
            <button type="submit" class="register-button">
                Create Account
            </button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Basic script for focus effect, can be expanded
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused'); // You might need to define .focused style if needed
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
</script>
@endsection 
@extends('layouts.app')

@section('title', 'Login - Mileage')

@section('styles')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 120px 20px 40px;
        background: radial-gradient(ellipse at center, rgba(63, 76, 255, 0.1) 0%, transparent 70%);
    }
    
    .login-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 3rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 20px 60px var(--shadow);
        backdrop-filter: blur(20px);
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-header h1 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .login-header p {
        color: var(--text-secondary);
        font-size: 1rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: 1rem;
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
    
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .checkbox-group input[type="checkbox"] {
        accent-color: var(--primary-color);
    }
    
    .checkbox-group label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        cursor: pointer;
    }
    
    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .forgot-password:hover {
        color: var(--secondary-color);
    }
    
    .login-button {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .login-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(63, 76, 255, 0.3);
    }
    
    .divider {
        position: relative;
        text-align: center;
        margin: 2rem 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--border-color);
        z-index: 1;
    }
    
    .divider span {
        background: var(--card-color);
        padding: 0 1rem;
        position: relative;
        z-index: 2;
    }
    
    .social-login {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .social-btn {
        flex: 1;
        padding: 0.875rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--surface-color);
        color: var(--text-primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .social-btn:hover {
        border-color: var(--primary-color);
        background: var(--card-color);
        transform: translateY(-2px);
    }
    
    .google-btn {
        color: #db4437;
    }
    
    .signup-link {
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .signup-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .signup-link a:hover {
        color: var(--secondary-color);
    }
    
    /* Alert styles */
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    
    .alert-error {
        background: rgba(248, 113, 113, 0.1);
        border: 1px solid rgba(248, 113, 113, 0.2);
        color: #f87171;
    }
    
    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }
    
    /* Responsive */
    @media (max-width: 480px) {
        .login-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .login-header h1 {
            font-size: 1.75rem;
        }
        
        .social-login {
            flex-direction: column;
        }
    }
    
    /* Custom SweetAlert styling */
    .swal-custom-popup {
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card fade-in">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your Mileage account</p>
        </div>
        
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Enter your password"
                    required
                >
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-options">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            
            <button type="submit" class="login-button">
                Sign In
            </button>
        </form>
        
        <div class="divider">
            <span>Or continue with</span>
        </div>
        
        <div class="social-login">
            <a href="#" class="social-btn google-btn" onclick="alert('Google login will be implemented soon')">
                <i class="bi bi-google"></i>
                Google
            </a>
            <a href="#" class="social-btn" onclick="alert('Facebook login will be implemented soon')">
                <i class="bi bi-facebook"></i>
                Facebook
            </a>
        </div>
        
        <div class="signup-link">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show SweetAlert for login errors
        @if ($errors->any() || session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '@if($errors->has("email")){{ $errors->first("email") }}@elseif($errors->has("password")){{ $errors->first("password") }}@elseif(session("error")){{ session("error") }}@else Login credentials are incorrect. Please try again.@endif',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#3F4CFF',
                background: 'var(--card-color)',
                color: 'var(--text-primary)',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session("success") }}',
                confirmButtonText: 'Continue',
                confirmButtonColor: '#22C55E',
                background: 'var(--card-color)',
                color: 'var(--text-primary)',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        @endif
        
        // Add focus animations to form inputs
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
        
        // Social login hover effects
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection 
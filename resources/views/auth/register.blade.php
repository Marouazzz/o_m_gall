@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
        <style>
            :root {
                --pink: #e8c4c4;
                --pink-light: #f5e6e8;
                --pink-lighter: #faf2f3;
                --pink-dark: #d9a7a7;
                --pink-darker: #c99393;
                --gold: #d4af37;
                --gold-light: #e8d9a0;
                --text-dark: #3a3a3a;
                --text-light: #5c5c5c;
            }

            body {
                background: var(--pink-lighter);
                font-family: 'Montserrat', sans-serif;
                color: var(--text-dark);
                position: relative;
                overflow-x: hidden;
            }

            .register-watermark {
                position: absolute;
                font-size: 15vw;
                font-weight: 800;
                color: rgba(232, 196, 196, 0.15);
                z-index: 0;
                pointer-events: none;
                top: 15%;
                left: 50%;
                transform: translate(-50%, -50%);
                white-space: nowrap;
                font-family: 'Playfair Display', serif;
            }

            .register-container {
                max-width: 500px;
                margin: 4rem auto;
                padding: 0 20px;
                position: relative;
                z-index: 1;
            }

            .register-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 15px 30px rgba(200, 147, 147, 0.15);
                padding: 3rem;
                border: 1px solid var(--pink-light);
                position: relative;
                overflow: hidden;
            }

            .register-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 8px;
                background: linear-gradient(to right, var(--pink), var(--gold-light));
            }

            .register-header {
                text-align: center;
                margin-bottom: 2.5rem;
                position: relative;
                padding-bottom: 1rem;
            }

            .register-header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 25%;
                width: 50%;
                height: 1px;
                background: linear-gradient(to right, transparent, var(--gold), transparent);
            }

            .register-header h1 {
                font-size: 1.8rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.5rem;
                font-family: 'Playfair Display', serif;
                letter-spacing: 0.5px;
            }

            .register-header p {
                color: var(--text-light);
                font-weight: 400;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
            }

            .field-container {
                background: var(--pink-lighter);
                border-radius: 10px;
                padding: 1.8rem;
                margin-bottom: 1.8rem;
                border: 1px solid var(--pink-light);
                transition: all 0.3s ease;
                position: relative;
            }

            .field-container:hover {
                border-color: var(--pink-dark);
            }

            .form-label {
                display: block;
                margin-bottom: 0.8rem;
                font-weight: 500;
                color: var(--text-dark);
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                letter-spacing: 0.3px;
            }

            .form-label i {
                margin-right: 10px;
                color: var(--gold);
                font-size: 1.1rem;
            }

            .form-control {
                width: 100%;
                padding: 12px 16px;
                border: 1px solid var(--pink-light);
                border-radius: 8px;
                font-size: 0.95rem;
                background: white;
                transition: all 0.3s ease;
                font-family: 'Montserrat', sans-serif;
                color: var(--text-dark);
            }

            .form-control:focus {
                border-color: var(--gold);
                box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
                outline: none;
            }

            .btn-register {
                background: linear-gradient(to right, var(--pink), var(--pink-dark));
                color: white;
                border: none;
                padding: 15px;
                border-radius: 8px;
                font-weight: 500;
                font-size: 1rem;
                width: 100%;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(200, 147, 147, 0.2);
                letter-spacing: 0.5px;
                font-family: 'Playfair Display', serif;
                text-transform: uppercase;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin-top: 1.5rem;
            }

            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(200, 147, 147, 0.3);
            }

            .btn-register i {
                font-size: 1.1rem;
                transition: transform 0.3s ease;
            }

            .btn-register:hover i {
                transform: translateX(3px);
            }

            .text-danger {
                color: #c77373;
                font-size: 0.8rem;
                margin-top: 0.5rem;
                font-weight: 400;
                display: block;
            }

            .register-footer {
                text-align: center;
                margin-top: 2rem;
                font-size: 0.9rem;
                color: var(--text-light);
            }

            .register-footer a {
                color: var(--pink-darker);
                text-decoration: none;
                border-bottom: 1px dotted var(--pink-darker);
                transition: all 0.2s ease;
            }

            .register-footer a:hover {
                color: var(--text-dark);
                border-bottom-color: var(--text-dark);
            }

            .password-toggle {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gold);
                cursor: pointer;
                font-size: 1.1rem;
            }

            .ornament {
                position: absolute;
                opacity: 0.1;
                z-index: 0;
            }

            .ornament-1 {
                top: 20px;
                right: 20px;
                font-size: 3rem;
                transform: rotate(15deg);
            }

            .ornament-2 {
                bottom: 20px;
                left: 20px;
                font-size: 3rem;
                transform: rotate(-15deg);
            }

            @media (max-width: 640px) {
                .register-watermark {
                    font-size: 20vw;
                }

                .register-card {
                    padding: 2rem;
                }
            }
        </style>
    @endpush

    <!-- Background watermark text -->
    <div class="register-watermark">Register</div>

    <div class="register-container">
        <div class="register-card">
            <!-- Decorative ornaments -->
            <div class="ornament ornament-1">✧</div>
            <div class="ornament ornament-2">✧</div>

            <div class="register-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 2.5rem; margin-bottom: 1rem;">
                <h1>Join Our Community</h1>
                <p>Create your account in just a few steps</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Field -->
                <div class="field-container">
                    <label for="name" class="form-label">
                        <i class="bi bi-person"></i> Full Name
                    </label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Your full name">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username Field -->
                <div class="field-container">
                    <label for="username" class="form-label">
                        <i class="bi bi-at"></i> Username
                    </label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required placeholder="Choose a username">
                    @error('username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="field-container">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i> Email Address
                    </label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="field-container">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i> Password
                    </label>
                    <div style="position: relative;">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Create a password">
                        <span class="password-toggle" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="field-container">
                    <label for="password-confirm" class="form-label">
                        <i class="bi bi-lock-fill"></i> Confirm Password
                    </label>
                    <div style="position: relative;">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm your password">
                        <span class="password-toggle" id="toggleConfirmPassword">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <span>Create Account</span>
                    <i class="bi bi-arrow-right"></i>
                </button>

                <div class="register-footer">
                    Already have an account?
                    <a href="{{ route('login') }}">Log in</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password toggle functionality
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('password');
                const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
                const confirmPasswordInput = document.getElementById('password-confirm');

                if (togglePassword && passwordInput) {
                    togglePassword.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('bi-eye');
                        icon.classList.toggle('bi-eye-slash');
                    });
                }

                if (toggleConfirmPassword && confirmPasswordInput) {
                    toggleConfirmPassword.addEventListener('click', function() {
                        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        confirmPasswordInput.setAttribute('type', type);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('bi-eye');
                        icon.classList.toggle('bi-eye-slash');
                    });
                }

                // Register button loading state
                const registerButton = document.querySelector('.btn-register');
                const registerForm = document.querySelector('form');

                if (registerButton && registerForm) {
                    registerForm.addEventListener('submit', function() {
                        registerButton.disabled = true;
                        registerButton.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Creating Account...';
                    });
                }
            });
        </script>
    @endpush
@endsection

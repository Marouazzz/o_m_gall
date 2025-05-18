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
            }

            .edit-container {
                max-width: 800px;
                margin: 2rem auto;
                padding: 0 20px;
            }

            .profile-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 15px 30px rgba(200, 147, 147, 0.15);
                padding: 3rem;
                border: 1px solid var(--pink-light);
                position: relative;
                overflow: hidden;
            }

            .profile-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 8px;
                background: linear-gradient(to right, var(--pink), var(--gold-light));
            }

            .profile-header {
                text-align: center;
                margin-bottom: 2.5rem;
                position: relative;
                padding-bottom: 1rem;
            }

            .profile-header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 25%;
                width: 50%;
                height: 1px;
                background: linear-gradient(to right, transparent, var(--gold), transparent);
            }

            .profile-header h1 {
                font-size: 1.8rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.5rem;
                font-family: 'Playfair Display', serif;
                letter-spacing: 0.5px;
            }

            .profile-header p {
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

            textarea.form-control {
                min-height: 120px;
                resize: vertical;
            }

            .avatar-section {
                text-align: center;
                margin-bottom: 2.5rem;
            }

            .avatar-preview {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid white;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                margin-bottom: 1.5rem;
            }

            .file-upload-btn {
                display: inline-block;
                padding: 10px 22px;
                background: white;
                color: var(--text-dark);
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                border: 1px solid var(--pink);
                letter-spacing: 0.3px;
            }

            .file-upload-btn:hover {
                background: var(--pink-light);
                color: var(--text-dark);
                border-color: var(--pink-dark);
            }

            .file-input {
                display: none;
            }

            .btn-save {
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

            .btn-save:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(200, 147, 147, 0.3);
            }

            .btn-save i {
                font-size: 1.1rem;
            }

            .text-danger {
                color: #c77373;
                font-size: 0.8rem;
                margin-top: 0.5rem;
                font-weight: 400;
                display: block;
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

            @media (min-width: 768px) {
                .form-row {
                    display: flex;
                    gap: 1.5rem;
                }
                .form-col {
                    flex: 1;
                }
            }
        </style>
    @endpush

    <div class="edit-container">
        <div class="profile-card">
            <!-- Decorative ornaments -->
            <div class="ornament ornament-1">✧</div>
            <div class="ornament ornament-2">✧</div>

            <div class="profile-header">
                <h1>Edit Profile</h1>
                <p>Refine your presence</p>
            </div>

            <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
                @csrf
                @method('PATCH')

                <!-- Avatar Section -->
                <div class="avatar-section">
                    @if($user->profile->image)
                        <img src="{{ asset('storage/' . $user->profile->image) }}" class="avatar-preview" id="avatarPreview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e8c4c4&color=5c5c5c"
                             class="avatar-preview" id="avatarPreview">
                    @endif
                    <label class="file-upload-btn">
                        <i class="bi bi-pencil"></i> Change Photo
                        <input type="file" id="image" name="image" class="file-input" accept="image/*">
                    </label>
                    @error('image')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Username Field -->
                <div class="field-container">
                    <label for="username" class="form-label">
                        <i class="bi bi-person"></i> Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control"
                           value="{{ old('username') ?? $user->username }}" required>
                    @error('username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Title Field -->
                <div class="field-container">
                    <label for="title" class="form-label">
                        <i class="bi bi-person-badge"></i> Profile Title
                    </label>
                    <input type="text" id="title" name="title" class="form-control"
                           value="{{ old('title') ?? $user->profile->title }}" required>
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="field-container">
                    <label for="description" class="form-label">
                        <i class="bi bi-journal-text"></i> About You
                    </label>
                    <textarea id="description" name="description" class="form-control"
                              rows="4" required>{{ old('description') ?? $user->profile->description }}</textarea>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Website Field -->
                <div class="field-container">
                    <label for="url" class="form-label">
                        <i class="bi bi-link-45deg"></i> Website
                    </label>
                    <input type="url" id="url" name="url" class="form-control"
                           value="{{ old('url') ?? $user->profile->url }}" placeholder="https://">
                    @error('url')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-save">
                    <i class="bi bi-check-circle"></i>
                    <span>Save Profile</span>
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image preview
                const imageInput = document.getElementById('image');
                const avatarPreview = document.getElementById('avatarPreview');

                if (imageInput && avatarPreview) {
                    imageInput.addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                avatarPreview.src = event.target.result;
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection

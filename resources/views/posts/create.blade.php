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

            .post-container {
                max-width: 800px;
                margin: 2rem auto;
                padding: 0 20px;
            }

            .post-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 15px 30px rgba(200, 147, 147, 0.15);
                padding: 2.5rem;
                border: 1px solid var(--pink-light);
                position: relative;
                overflow: hidden;
            }

            .post-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 8px;
                background: linear-gradient(to right, var(--pink), var(--gold-light));
            }

            .post-header {
                text-align: center;
                margin-bottom: 2.5rem;
                position: relative;
                padding-bottom: 1rem;
            }

            .post-header::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 25%;
                width: 50%;
                height: 1px;
                background: linear-gradient(to right, transparent, var(--gold), transparent);
            }

            .post-header h1 {
                font-size: 1.8rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.5rem;
                font-family: 'Playfair Display', serif;
                letter-spacing: 0.5px;
            }

            .form-group {
                margin-bottom: 1.8rem;
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

            .form-control, .form-control-file {
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

            .form-control:focus, .form-control-file:focus {
                border-color: var(--gold);
                box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
                outline: none;
            }

            .form-control-file {
                padding: 12px 0;
            }

            .btn-submit {
                background: linear-gradient(to right, var(--pink), var(--pink-dark));
                color: white;
                border: none;
                padding: 14px;
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
            }

            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(200, 147, 147, 0.3);
            }

            .btn-submit i {
                font-size: 1.1rem;
            }

            .invalid-feedback {
                color: #c77373;
                font-size: 0.8rem;
                margin-top: 0.5rem;
                font-weight: 400;
                display: block;
            }

            .is-invalid {
                border-color: #c77373 !important;
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

            .image-preview-container {
                text-align: center;
                margin-bottom: 1.8rem;
            }

            .image-preview {
                max-width: 100%;
                max-height: 300px;
                border-radius: 8px;
                border: 1px dashed var(--pink-dark);
            }

            .text-muted {
                color: var(--text-light);
                font-size: 0.8rem;
                display: block;
                margin-top: 0.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imageInput = document.getElementById('image');
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('imagePreview');

                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush

    <div class="post-container">
        <div class="post-card">
            <!-- Decorative ornaments -->
            <div class="ornament ornament-1">✧</div>
            <div class="ornament ornament-2">✧</div>

            <form action="/p" enctype="multipart/form-data" method="post">
                @csrf

                <div class="post-header">
                    <h1>Add New Post</h1>
                </div>

                <div class="form-group">
                    <label for="caption" class="form-label">
                        <i class="bi bi-pencil-square"></i> Post Caption
                    </label>
                    <input id="caption"
                           type="text"
                           class="form-control @error('caption') is-invalid @enderror"
                           name="caption"
                           value="{{ old('caption') }}"
                           required autocomplete="caption" autofocus>
                    @error('caption')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags" class="form-label">
                        <i class="bi bi-tags"></i> Tags
                    </label>
                    <input id="tags"
                           type="text"
                           class="form-control @error('tags') is-invalid @enderror"
                           name="tags"
                           value="{{ old('tags') }}"
                           placeholder="#cool #nature #fun">
                    <small class="text-muted">Separate tags with spaces (e.g., #cool #nature)</small>
                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">
                        <i class="bi bi-image"></i> Post Image
                    </label>
                    <input type="file"
                           class="form-control-file @error('image') is-invalid @enderror"
                           id="image"
                           name="image"
                           required>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                    <img id="imagePreview" src="#" alt="Preview" class="image-preview"/>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-plus-circle"></i> Create Post
                </button>
            </form>
        </div>
    </div>
@endsection

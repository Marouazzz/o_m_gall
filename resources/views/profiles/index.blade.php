@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Profile Section -->
        <div class="row">
            <!-- Left: Profile Picture -->
            <div class="col-md-3 p-4">
                <div class="d-flex justify-content-center">
                    <img src="{{ $user->profile->profileImage() }}"
                         class="rounded-circle w-75 border-3 border-light shadow-sm"
                         style="border-color: #f8d7da !important;"
                         alt="{{ $user->username }} profile">
                </div>
            </div>

            <!-- Right: Profile Details -->
            <div class="col-md-9 pt-4">
                <!-- Username & Actions -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <h1 class="h3 me-3 fw-light" style="color: #6c757d;">{{ '@' . $user->username }}</h1>
                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    </div>

                    @auth
                        @if(auth()->user()->id === $user->id)
                            <div class="d-flex gap-2">
                                <a href="/p/create" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-plus"></i> New Post
                                </a>
                                <a href="/profile/{{ $user->id }}/edit" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-cog"></i> Edit Profile
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Stats -->
                <div class="d-flex mb-4">
                    <div class="me-4"><strong class="text-dark">{{ $postCount }}</strong> <span class="text-muted">posts</span></div>
                    <div class="me-4"><strong class="text-dark">{{ $followersCount }}</strong> <span class="text-muted">followers</span></div>
                    <div class="me-4"><strong class="text-dark">{{ $followingCount }}</strong> <span class="text-muted">following</span></div>
                </div>

                <!-- Bio -->
                @if ($user->profile)
                    <div class="mb-3">
                        <h4 class="h5 fw-normal mb-1" style="color: #495057;">{{ $user->profile->title ?? '' }}</h4>
                        <p class="mb-2" style="color: #6c757d; font-family: 'Georgia', serif;">{{ $user->profile->description ?? '' }}</p>
                        <a href="{{ $user->profile->url }}" class="text-decoration-none" style="color: #d63384;">
                            <i class="fas fa-link me-1"></i> {{ parse_url($user->profile->url, PHP_URL_HOST) }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Posts Grid (Old Money Aesthetic) -->
        <div class="row pt-5">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach($user->posts as $post)
                        <div class="col">
                            <a href="/p/{{ $post->id }}" class="d-block position-relative">
                                <img src="{{ asset('storage/'.$post->image) }}"
                                     alt="{{ $post->caption }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="width: 100%; height: 300px; object-fit: cover; filter: brightness(0.95);">
                                <!-- Subtle hover effect -->
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-0 hover-opacity-10 transition-all"
                                     style="pointer-events: none;"></div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


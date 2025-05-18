@extends('layouts.app')

@section('content')
    <div class="container-fluid app-container" style="min-height: 100vh; padding: 0;">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Search Box -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" id="tagSearch" class="form-control" placeholder="Search by tags (e.g., nature, travel)"
                               style="border-radius: 15px; border: 1px solid #C0A080; background-color: #F9F5F0;">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch"
                                style="border-radius: 15px; margin-left: 5px; border-color: #C0A080; color: #C0A080;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="row justify-content-center" id="post-grid">
                @foreach($posts as $post)
                    <div class="col-md-5 col-lg-4 mb-4 post-card-container post-item"
                         data-aos="fade-up"
                         data-aos-delay="{{ $loop->index * 100 }}"
                         data-tags="{{ $post->tags->pluck('name')->implode(',') }}">
                        <div class="card border-0 shadow-sm post-card">
                            <!-- User Header with Profile Picture -->
                            <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-0 pb-0">
                                <a href="/profile/{{ $post->user->id }}" class="text-decoration-none user-link">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $post->user->profile->profileImage() }}"
                                             class="rounded-circle me-2 profile-img"
                                             style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #C0A080;">
                                        <span class="fw-bold username-text">
                                    {{ $post->user->username }}
                                </span>
                                    </div>
                                </a>

                                @auth
                                    @if($post->user->id === auth()->user()->id)
                                        <button class="btn btn-sm delete-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deletePostModal-{{ $post->id }}"
                                                style="background-color: rgba(184, 107, 119, 0.1); color: #B86B77;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                @endauth
                            </div>

                            <!-- Post Image -->
                            <div class="card-body pt-2">
                                <a href="/p/{{ $post->id }}">
                                    <img src="/storage/{{ $post->image }}"
                                         class="post-image w-100 rounded"
                                         style="object-fit: cover;
                                        height: 350px;
                                        border: 1px solid rgba(192, 160, 128, 0.3);">
                                </a>

                                <!-- Like and Caption Section -->
                                <div class="mt-3 px-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="caption-container" style="max-height: 100px; overflow-y: auto;">
                                            <p class="mb-1 username-caption">{{ $post->user->username }}</p>
                                            <p class="mb-2 post-caption">{{ $post->caption }}</p>
                                        </div>

                                        <!-- Like and Save Buttons -->
                                        <div class="d-flex align-items-center">
                                            <!-- Like Button -->
                                            <div class="like-container me-3">
                                                <button class="btn-like bg-transparent border-0 p-0"
                                                        data-post-id="{{ $post->id }}"
                                                        style="font-size: 1.5rem; outline: none;">
                                                    @auth
                                                        @if(auth()->user()->hasLiked($post))
                                                            ❤️
                                                        @else
                                                            🤍
                                                        @endif
                                                    @else
                                                        🤍
                                                    @endauth
                                                </button>
                                                <span class="like-count" data-post-id="{{ $post->id }}" style="color: #B86B77; font-weight: 600;">
                                            {{ $post->likers()->count() }}
                                        </span>
                                            </div>

                                            <!-- Save Button -->
                                            <form method="POST" class="save-post-form" data-post-id="{{ $post->id }}">
                                                @csrf
                                                <button type="submit" class="btn-save bg-transparent border-0 p-0" style="font-size: 1.5rem; outline: none;">
                                                    @auth
                                                        @if(auth()->user()->savedPosts->contains($post->id))
                                                            📌
                                                        @else
                                                            📍
                                                        @endif
                                                    @else
                                                        📍
                                                    @endauth
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Tags -->
                                    <div class="d-flex gap-2 flex-wrap mt-3">
                                        @foreach($post->tags as $tag)
                                            <span class="badge tag-badge" style="background-color: rgba(184, 107, 119, 0.1); color: #B86B77; cursor: pointer;">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>

                                    <!-- Date -->
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted" style="color: #C0A080 !important;">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deletePostModal-{{ $post->id }}" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="
                        background: linear-gradient(145deg, #F9F5F0, #F3E0E5);
                        border: 2px solid #C0A080;
                        border-radius: 15px;
                    ">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" style="color: #B86B77; font-weight: 800;">Delete Post?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="color: #3A2E2A;">
                                    <p>Are you sure you want to delete this post?</p>
                                    <div class="text-center my-3">
                                        <img src="/storage/{{ $post->image }}" class="img-fluid rounded" style="max-height: 150px; border: 2px dashed #C0A080;">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="background: linear-gradient(45deg, #B86B77, #D8A7B1); color: white;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results -->
            <div id="noResults" class="text-center mt-5" style="display: none;">
                <h4 style="color: #B86B77;">No posts found matching your search</h4>
                <button class="btn mt-3" id="resetSearch"
                        style="background: linear-gradient(45deg, #B86B77, #D8A7B1); color: white;">
                    Show All Posts
                </button>
            </div>

            <!-- Pagination -->
            @if($posts->count() > 0)
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>

        <!-- Floating Post Button -->
        @auth
            <div class="floating-action-btn">
                <a href="/p/create" class="btn btn-lg rounded-circle shadow"
                   style="background: linear-gradient(45deg, #FF80AB, #D81B60); color: white;
                  width: 60px; height: 60px; display: flex; align-items: center;
                  justify-content: center; position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
                    <i class="fas fa-plus"></i>
                </a>
                <!-- Saved Posts Button -->
                <a href="{{ route('saved.posts') }}" class="btn btn-lg rounded-circle shadow floating-action-btn"
                   style="background: linear-gradient(45deg, #D81B60, #FF4081); color: white;
                  width: 60px; height: 60px; display: flex; align-items: center;
                  justify-content: center; position: fixed; bottom: 100px; right: 30px; z-index: 1000;">
                    <i class="fas fa-bookmark"></i>
                </a>
            </div>
        @endauth
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS animations
            AOS.init({
                duration: 800,
                easing: 'ease-in-out-back',
                once: true
            });

            // Sidebar toggle for mobile
            const sidebarToggle = document.querySelector('.sidebar-toggle-btn');
            const sidebar = document.querySelector('.sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && event.target !== sidebarToggle) {
                        sidebar.classList.remove('active');
                    }
                }
            });

            // Search functionality
            const tagSearch = document.getElementById('tagSearch');
            const clearSearch = document.getElementById('clearSearch');
            const resetSearch = document.getElementById('resetSearch');
            const postItems = document.querySelectorAll('.post-item');
            const noResults = document.getElementById('noResults');

            function filterPosts() {
                const searchTerm = tagSearch.value.trim().toLowerCase();
                let hasVisiblePosts = false;
                postItems.forEach(item => {
                    const tags = item.dataset.tags.toLowerCase();
                    if (searchTerm === '' || tags.includes(searchTerm)) {
                        item.style.display = 'block';
                        hasVisiblePosts = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                noResults.style.display = hasVisiblePosts ? 'none' : 'block';
            }

            tagSearch.addEventListener('input', filterPosts);
            clearSearch.addEventListener('click', () => { tagSearch.value = ''; filterPosts(); });
            resetSearch.addEventListener('click', () => { tagSearch.value = ''; filterPosts(); });

            document.querySelectorAll('.tag-badge').forEach(tag => {
                tag.addEventListener('click', function() {
                    tagSearch.value = this.textContent.trim();
                    filterPosts();
                });
            });

            // Like Button Functionality
            document.querySelectorAll('.btn-like').forEach(button => {
                button.addEventListener('click', function() {
                    @auth
                    const postId = this.getAttribute('data-post-id');
                    const likeCountElement = document.querySelector(`.like-count[data-post-id="${postId}"]`);
                    axios.post(`/posts/${postId}/like`)
                        .then(response => {
                            this.innerHTML = response.data.is_liked ? '❤️' : '🤍';
                            animateValue(likeCountElement, parseInt(likeCountElement.textContent), response.data.likes_count, 500);
                            this.style.transform = 'scale(1.3)';
                            setTimeout(() => { this.style.transform = 'scale(1)'; }, 300);
                        })
                        .catch(error => {
                            if (error.response.status === 401) window.location = '/login';
                        });
                    @else
                        window.location = '/login';
                    @endauth
                });
            });

            // Save Button Functionality
            document.querySelectorAll('.save-post-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-post-id');
                    const button = this.querySelector('.btn-save');
                    const isSaved = button.textContent.includes('📌');

                    const url = isSaved ? `/posts/${postId}/unsave` : `/posts/${postId}/save`;
                    const method = isSaved ? 'DELETE' : 'POST';

                    axios({ method, url })
                        .then(response => {
                            button.innerHTML = isSaved ? '📍' : '📌';
                            // Add animation effect
                            button.style.transform = 'scale(1.3)';
                            setTimeout(() => { button.style.transform = 'scale(1)'; }, 300);
                        })
                        .catch(error => {
                            if (error.response.status === 401) {
                                window.location.href = '/login';
                            }
                        });
                });
            });

            // Animate number counting
            function animateValue(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    element.textContent = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Card hover effects
            document.querySelectorAll('.post-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'perspective(1000px) rotateX(5deg) rotateY(5deg) scale(1.03)';
                    card.style.boxShadow = '0 10px 25px rgba(184, 107, 119, 0.1)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
                    card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                });
            });
        });
    </script>

    <style>
        :root {
            --primary-pink: #D8A7B1; /* Muted pink */
            --primary-dark-pink: #B86B77; /* Deeper pink */
            --primary-light-pink: #F3E0E5; /* Soft pink */
            --gold-accent: #C0A080; /* Old money gold */
            --ivory: #F9F5F0; /* Creamy ivory */
            --text-dark: #3A2E2A; /* Dark brown */
        }

        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--ivory);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* App Container */
        .app-container {
            display: flex;
            position: relative;
        }

        /* Sidebar Toggle Button (Mobile) */
        .sidebar-toggle-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gold-accent);
            color: white;
            border: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(192, 160, 128, 0.3);
        }

        .sidebar-toggle-btn i {
            font-size: 18px;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px;
            min-height: calc(100vh - 56px);
            background: linear-gradient(180deg, var(--ivory), #F3EBE0);
            box-shadow: 5px 0 15px rgba(192, 160, 128, 0.2);
            z-index: 1000;
            padding: 30px 0;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            border-right: 1px solid var(--gold-accent);
        }

        .sidebar-header {
            text-align: center;
            padding: 0 25px 25px;
            border-bottom: 1px solid rgba(192, 160, 128, 0.3);
        }

        .sidebar-profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid var(--gold-accent);
            border-radius: 50%;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(192, 160, 128, 0.3);
            transition: all 0.3s ease;
        }

        .sidebar-profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(192, 160, 128, 0.4);
        }

        .sidebar-username {
            color: var(--primary-dark-pink);
            font-weight: 700;
            margin: 10px 0 5px;
            font-size: 1.2rem;
        }

        .sidebar-bio {
            color: var(--text-dark);
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 15px 30px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-item:hover {
            background: rgba(216, 167, 177, 0.1);
            color: var(--primary-dark-pink);
            padding-left: 35px;
        }

        .sidebar-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: var(--gold-accent);
            border-radius: 0 5px 5px 0;
        }

        .sidebar-item i {
            margin-right: 15px;
            color: var(--gold-accent);
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .message-badge {
            background: var(--primary-dark-pink);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            position: absolute;
            right: 25px;
        }

        .sidebar-footer {
            padding: 0 25px;
        }

        .sidebar-stats {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            border-top: 1px solid rgba(192, 160, 128, 0.3);
            border-bottom: 1px solid rgba(192, 160, 128, 0.3);
            margin-bottom: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-weight: 700;
            color: var(--primary-dark-pink);
            font-size: 1.1rem;
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-dark);
            opacity: 0.8;
        }

        .color-palette {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .color-option:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .color-option[data-color="light"] {
            background: linear-gradient(45deg, #F9F5F0, #D8A7B1);
        }

        /* Main content adjustment */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s ease;
            width: calc(100% - 280px);
        }

        /* Search box styling */
        #tagSearch {
            background-color: var(--ivory);
            border: 1px solid var(--gold-accent) !important;
            color: var(--text-dark);
        }

        #clearSearch {
            border-color: var(--gold-accent) !important;
            color: var(--gold-accent) !important;
        }

        /* Post Card Styles */
        .post-card {
            background: var(--ivory);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(192, 160, 128, 0.5);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 20px;
        }

        .post-card:hover {
            box-shadow: 0 10px 25px rgba(184, 107, 119, 0.1);
        }

        .profile-img {
            border: 2px solid var(--gold-accent);
        }

        .username-text {
            color: var(--primary-dark-pink);
        }

        .delete-btn {
            background-color: rgba(184, 107, 119, 0.1) !important;
            color: var(--primary-dark-pink) !important;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-btn:hover {
            background-color: rgba(184, 107, 119, 0.2) !important;
        }

        /* Like and Save buttons */
        .btn-like, .btn-save {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-like:hover, .btn-save:hover {
            transform: scale(1.2);
        }

        /* Caption Styles */
        .username-caption {
            color: var(--primary-dark-pink);
            font-weight: 600;
            display: inline;
        }

        .post-caption {
            color: var(--text-dark);
            display: inline;
        }

        /* Tags */
        .tag-badge {
            cursor: pointer;
            transition: all 0.2s ease;
            background-color: rgba(184, 107, 119, 0.1) !important;
            color: var(--primary-dark-pink) !important;
        }

        .tag-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(184, 107, 119, 0.1);
        }

        /* No results message */
        #noResults h4 {
            color: var(--primary-dark-pink);
        }

        #resetSearch {
            background: linear-gradient(45deg, var(--primary-dark-pink), var(--primary-pink)) !important;
        }

        /* Pagination Styling */
        .pagination .page-item.active .page-link {
            background: linear-gradient(45deg, var(--primary-dark-pink), var(--primary-pink));
            border-color: transparent;
            color: white;
        }

        .pagination .page-link {
            color: var(--primary-dark-pink);
            border: 1px solid var(--gold-accent);
            margin: 0 5px;
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: rgba(216, 167, 177, 0.1);
        }

        /* Floating Action Menu */
        .floating-action-menu {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .fab-toggle {
            display: none;
        }

        .fab-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--gold-accent), #B89E80);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(192, 160, 128, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1001;
        }

        .fab-btn i {
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .fab-toggle:checked + .fab-btn {
            transform: rotate(45deg);
        }

        .fab-options {
            position: absolute;
            bottom: 70px;
            right: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .fab-toggle:checked ~ .fab-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .fab-option {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--gold-accent), #B89E80);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 4px 10px rgba(192, 160, 128, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .fab-option:hover {
            transform: scale(1.1);
        }

        .fab-option i {
            font-size: 20px;
        }

        .fab-option::after {
            content: attr(data-tooltip);
            position: absolute;
            right: 60px;
            background: rgba(58, 46, 42, 0.9);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .fab-option:hover::after {
            opacity: 1;
            right: 70px;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle-btn {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            .post-card-container {
                padding: 0 15px;
            }
            .fab-btn {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100" style="max-width: 450px; display: flex; align-items: center; justify-content: center;">
            </div>
            <div class="col-4">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <img src="{{ $post->user->profile->profileImage()}}" class="rounded-circle w-100" style="max-width: 40px;">
                            </div>
                            <div>
                                <div class="font-weight-bold">
                                    <a href="/profile/{{ $post->user->id }}">
                                        <span class="text-black font-bold">{{ $post->user->username }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @auth
                            @if($post->user->id === auth()->user()->id)
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal-{{ $post->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        @endauth
                    </div>
                    <div class="mt-3">
                        @foreach($post->tags as $tag)
                            <a href="/posts?tag={{ urlencode($tag->name) }}" class="badge bg-primary text-decoration-none me-1">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                    <hr>

                    <p>
                        <span class="font-weight-bold">
                            <a href="/profile/{{ $post->user->id }}">
                                <span class="text-dark font-bold">{{ $post->user->username }}</span>
                            </a>
                        </span><br>
                        <span>{{ $post->caption }}</span>
                    </p>

                    <!-- Like Button Section -->
                    <div class="d-flex align-items-center pt-2">
                        <button class="btn-like bg-transparent border-0 p-0 mr-2"
                                data-post-id="{{ $post->id }}"
                                style="font-size: 1.5rem; outline: none; cursor: pointer;">
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
                        <span class="like-count" data-post-id="{{ $post->id }}">
                            {{ $post->likers()->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePostModal-{{ $post->id }}" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePostModalLabel">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Like button functionality
            document.querySelectorAll('.btn-like').forEach(button => {
                button.addEventListener('click', function() {
                    @auth
                    const postId = this.getAttribute('data-post-id');
                    const likeCountElement = document.querySelector(`.like-count[data-post-id="${postId}"]`);

                    axios.post(`/posts/${postId}/like`)
                        .then(response => {
                            // Toggle heart emoji
                            this.innerHTML = response.data.is_liked ? '❤️' : '🤍';

                            // Update like count
                            likeCountElement.textContent = response.data.likes_count;

                            // Add animation
                            this.style.transform = 'scale(1.2)';
                            setTimeout(() => {
                                this.style.transform = 'scale(1)';
                            }, 200);
                        })
                        .catch(error => {
                            if (error.response.status === 401) {
                                window.location = '/login';
                            }
                        });
                    @else
                        window.location = '/login';
                    @endauth
                });
            });
        });
    </script>

    <style>
        .btn-like {
            transition: transform 0.2s ease;
        }
        .btn-like:hover {
            opacity: 0.8;
        }
        .like-count {
            font-size: 1rem;
            margin-left: 5px;
        }
    </style>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Inbox</h1>

        <!-- Chat Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Messages</h3>
            </div>
            <div class="card-body">
                @if($messages->isEmpty())
                    <p>No messages yet.</p>
                @else
                    <ul class="list-group">
                        @foreach($messages as $message)
                            <li class="list-group-item">
                                <strong>{{ $message->sender->name }}:</strong>
                                {{ $message->content }}
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Posts Section -->
        <div class="card">
            <div class="card-header">
                <h3>Posts from Followed Users</h3>
            </div>
            <div class="card-body">
                @if($posts->isEmpty())
                    <p>No posts from followed users.</p>
                @else
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $post->user->name }}</h5>
                                        <p>{{ $post->content }}</p>
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

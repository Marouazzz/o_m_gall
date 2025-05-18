@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center" style="color: #B86B77;">Discover People</h2>
                <p class="text-center text-muted">Find new people to follow</p>
            </div>
        </div>

        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <a href="/profile/{{ $user->id }}">
                                <img src="{{ $user->profile->profileImage() }}"
                                     class="rounded-circle mb-3"
                                     style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #C0A080;">
                            </a>
                            <h5 class="mb-1">{{ $user->username }}</h5>
                            <p class="small text-muted mb-3">{{ $user->profile->title ?? 'Member' }}</p>

                            <follow-button
                                user-id="{{ $user->id }}"
                                follows="{{ auth()->user()->following->contains($user->id) ? 'true' : 'false' }}">
                            </follow-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

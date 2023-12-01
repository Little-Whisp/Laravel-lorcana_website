@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>All Posts</h2>
                @forelse ($posts ?? [] as $post)
                    <div class="card mb-3">
                        <div class="card-header">{{ $post->name }}</div>
                        <div class="card-body">
                            <p>{{ $post->detail }}</p>
                            <p>Category: {{ optional($post->category)->name }}</p>
                            <p>Visibility: {{ $post->is_visible ? 'Visible' : 'Not Visible' }}</p>
                        </div>
                    </div>
                @empty
                    <p>No posts available.</p>
                @endforelse

                <div>

                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 ml-3">Go to Home page</a>

                    <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3">Create a new post</a>

                    <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 ml-3">Go to Categories</a>

                </div>
            </div>
        </div>
    </div>
@endsection



@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h2>Lorcana cards</h2>
                <div>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 ml-3">Go to Home page</a>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <!-- Display the "Create Post" button for admins -->
                        <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3 ml-3">Create your own lorcana card</a>
                    @endif
                    <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 ml-3">Go to Categories</a>
                </div>

                @if(session('success_message'))
                    <div class="alert alert-success">
                        {{ session('success_message') }}
                    </div>
                @endif


                <div class="container">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-header">{{ $post->title }}</div>
                                    <div class="card-body">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 100%; height: auto;">
                                            <!-- Other card content goes here -->
                                        </div>                                        <p>{{ $post->detail }}</p>
                                        <p>Category: {{ optional($post->category)->name }}</p>
                                        <p>Visibility: {{ $post->is_visible ? 'Visible' : 'Not Visible' }}</p>
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Show</a>
                                        @if (Auth::check() && Auth::user()->role === 'admin')
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="post" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No posts available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection






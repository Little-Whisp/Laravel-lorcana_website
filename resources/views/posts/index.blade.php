@extends('layouts.app')

@section('content')
    <div class="container custom-container">
        <div class="section p-4 border">

            @if(Auth::check())
                <a href="{{ route('home') }}" class="btn btn-primary mt-3 ml-3">Back to dashboard</a>
            @endif

                <div class="row">
                <div class="col-md-8 mx-auto text-center">

                    <h2>Welcome to Lorcana's card library</h2>

                    @if (Auth::check() && Auth::user()->role === 'admin')

                    <div class="input-group-lg col col-auto">
                        @include('partials.search-post')
                    </div>

                        <div><a>You are an admin and can create/edit/delete posts and categories</a></div>
                        <!-- Display the "Create Post" button for admins -->
                        <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3 ml-3">Create your own lorcana card</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 ml-3">Go to Categories</a>
                    @endif

                </div>

                <br>

                <div class="container">
                    <div class="row">
                            @forelse ($posts ?? [] as $post)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-header">{{ $post->title }}</div>
                                    <div class="card-body">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                                 style="max-width: 100%; height: auto;">
                                        </div>

                                        <br>

                                        <p>Created by: {{ ($post->user)->name }}</p>
                                        @if (Auth::check() && Auth::user()->role === 'admin')
                                            <p>Visibility: {{ $post->is_visible ? 'Visible' : 'Not Visible' }}</p>
                                        @endif

                                        <br>

                                        @if (!Auth::check())
                                            <!-- Display the "Details" button for non-logged-in users -->
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                               data-bs-target="#postModal{{ $post->id }}">Details</a>
                                        @else
                                            <!-- Display the "View" button for logged-in users -->
                                            <a href="{{ route('posts.show', $post->id) }}"
                                               class="btn btn-primary">View</a>

                                            @if (Auth::check() && Auth::user()->role === 'admin')
                                                @if (Auth::user()->id === $post->user_id )
                                                <!-- Display additional action buttons for admins -->
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>

                                                <form action="{{ route('posts.destroy', $post->id) }}" method="post"
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                                        Delete
                                                    </button>
                                                </form>

                                                @endif
                                            @endif
                                        @endif

                                        <!-- Modal -->
                                        <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1"
                                             aria-labelledby="postModalLabel{{ $post->id }}" aria-hidden="true">
                                            <div class="modal-dialog custom-modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="postModalLabel{{ $post->id }}">{{ $post->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img src="{{ asset('storage/' . $post->image) }}"
                                                                     alt="Post Image"
                                                                     style="max-width: 100%; height: auto;">
                                                                <p>Created by: {{ ($post->user)->name }}</p>

                                                                <p>Categories:
                                                                    @forelse ($post->categories as $category)
                                                                        {{ $category->name }}
                                                                    @empty
                                                                        No categories available.
                                                                @endforelse                                                                <p>Details: {{ $post->detail }}</p>
                                                                <p>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
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


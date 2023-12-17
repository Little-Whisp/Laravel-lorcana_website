@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Search Results</h2>

        @if(count($posts) > 0)
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">{{ $post->title }}</div>
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 100%; height: auto;">
                                <p>Category: {{ optional($post->category)->name }}</p>
                                <p>{{ $post->detail }}</p>
                                <p>Visibility: {{ $post->is_visible ? 'Visible' : 'Not Visible' }}</p>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Show</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No results found.</p>
        @endif
    </div>
@endsection

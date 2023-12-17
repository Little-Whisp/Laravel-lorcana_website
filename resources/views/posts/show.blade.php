@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">
                <h2>{{ $post->title }}</h2>
                <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3 ml-3">Go to Home page</a>

                <div class="card">
                    <div class="card-body">
                        <p>{{ $post->detail }}</p>
                        <p>Category: {{ $post->category->name }}</p>
                        <p>Visibility: {{ $post->is_visible ? 'Visible' : 'Not Visible' }}</p>
                    </div>
                </div>
                <br>
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="post" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection


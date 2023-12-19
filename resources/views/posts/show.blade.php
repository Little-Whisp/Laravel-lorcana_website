@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="section p-4 border">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">
                <h2>{{ $post->title }}</h2>
                <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3 ml-3">Go to Home page</a>

                <div class="card">
                    <div class="card-body">
                        <p>{{ $post->detail }}</p>
                        <p>Categories:
                            @forelse ($post->categories as $category)
                                {{ $category->name }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @empty
                                No categories available.
                        @endforelse
                        <p>Created by: {{ ($post->user)->name }}</p>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    </div>
@endsection


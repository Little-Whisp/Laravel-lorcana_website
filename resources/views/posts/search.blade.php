@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="mb-4 col-6">
                <h2>List of Posts</h2>

                <div class="input-group-lg col col-auto">
                    <form action="{{ route('posts.search') }}" method="POST">
                        @csrf
                        <label for="search"></label><input type="text" class="form-control" name="search" id="search"
                                                           placeholder="Search...">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <br>
                </div>
                <h3>Search Results: </h3>
                @foreach($posts as $post)
                    <div class="card">
                        <div class="card-header"><h1><a href="/posts/{{$post->id}}"
                                                        class="link page-link">{{$post->name}}</a></h1>
                            @can('update', $post)
                                <a class="btn btn-secondary" href="{{route('posts.edit', $post->id)}}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <p>{{$post->detail}}</p>
                            <div>
                                <h3>

                                    @foreach($post->categories as $category)
                                        <btn class="btn btn-primary"><a class="link page-link text-white"
                                                                        href="/categories/{{$category->id}}">{{$category->name}}</a>
                                        </btn>
                                        @if($post->categories->count() > 1)

                                        @endif
                                    @endforeach
                                </h3>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>All Categories</h2>
                <a href="{{ route('main') }}" class="btn btn-primary mt-3 ml-3">Go back</a>
                <a href="{{ route('categories.create') }}" class="btn btn-primary mt-3 ml-3">Create a new category</a>
                @forelse ($categories as $category)
                    <div class="card mb-3">
                        <div class="card-header">{{ $category->name }}</div>
                        <div class="card-body">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No categories found.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

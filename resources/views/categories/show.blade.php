@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>{{ $category->name }}</h2>
                <div class="card">
                    <div class="card-body">
                        {{-- You can add additional details related to the category --}}
                    </div>
                </div>
                <br>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection

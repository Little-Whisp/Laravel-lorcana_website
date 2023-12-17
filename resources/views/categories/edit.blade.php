@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 ml-3">Go back</a>

        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">
                <h2>Edit Category</h2>
                <form action="{{ route('categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection

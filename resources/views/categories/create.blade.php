@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Create a New Category</h2>
                <form action="{{ route('categories.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection

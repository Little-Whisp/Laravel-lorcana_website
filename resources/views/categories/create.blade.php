@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="section p-4 border">

        <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 ml-3">Go back</a>

        <div class="row align-items-center">
            <div class="col-md-8 mx-auto">

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
    </div>
@endsection

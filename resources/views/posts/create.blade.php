@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Create a New Post</h2>
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Post Title</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="detail">Post Detail</label>
                        <textarea class="form-control" id="detail" name="detail" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Post Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" checked>
                        <label class="form-check-label" for="is_visible">Visible</label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </form>
            </div>
        </div>
    </div>
@endsection

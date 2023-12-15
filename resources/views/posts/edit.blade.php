@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Edit Post</h2>
                <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3 ml-3">Go back</a>

                <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Post Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="detail">Post Detail</label>
                        <textarea class="form-control" id="detail" name="detail" required>{{ $post->detail }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Post Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" {{ $post->is_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible">Visible</label>

                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>
        </div>
    </div>
@endsection


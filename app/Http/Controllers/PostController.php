<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate and store post
        // Implement your validation logic based on your requirements
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|mimes:jpg,jpeg,png|max:4096',
            'category_id' => 'required|exists:categories,id',
            // Add other fields as needed
        ]);

        Post::create($request->all());

        return redirect()->route('home')->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update post
        // Implement your validation logic based on your requirements
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|mimes:jpg,jpeg,png|max:4096',
            'category_id' => 'required|exists:categories,id',
            // Add other fields as needed
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('home')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully');
    }

    public function showAllPosts()
    {
        $posts = Post::all();
        return view('main', compact('posts'));
    }


}


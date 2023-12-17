<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\ViewedPost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function index()
    {
        // Retrieve all posts for admin users, including invisible ones
        if (Auth::check() && Auth::user()->role === 'admin') {
            $posts = Post::get();
        } else {
            // For non-admin users, retrieve only visible posts
            $posts = Post::where('is_visible', true)->get();
        }

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
            'title' => 'bail|required|max:255',
            'detail' => 'bail|required|max:255',
            'image' => 'required|mimes:jpg,jpeg,png|max:4096',
            'category_id' => 'required|exists:categories,id',
            // Add other fields as needed
        ]);

        // Assuming the 'image' field is a file, handle file upload
        $imagePath = $request->file('image')->store('post_images', 'public');

        // Create a new Post instance with the validated data
        $post = new Post([
            'title' => $request->input('title'),
            'detail' => $request->input('detail'),
            'image' => $imagePath,
            'category_id' => $request->input('category_id'),
            'is_visible' => $request->has('is_visible'),
        ]);

        // Save the post to the database
        $post->save();

        // Redirect back to the main page with a success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
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
        $request->validate([
            'title' => 'nullable|max:255',
            'detail' => 'nullable|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:4096', // Allow image to be nullable
            'is_visible' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            // Add other fields as needed
        ]);

        $post = Post::findOrFail($id);

        // Check if the 'image' file has been provided
        if ($request->hasFile('image')) {
            // Handle file upload and update image path
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image = $imagePath;
        }

        // Update other fields
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->is_visible = $request->has('is_visible');

        // Save the changes
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function show($postId)
    {
        $post = Post::findOrFail($postId);

        // Track post view
        $this->trackPostView($post);

        return view('posts.show', compact('post'));
    }

    private function trackPostView($post)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user has already viewed this post
            if (!$user->viewed_posts()->where('post_id', $post->id)->exists()) {

                // Increment the viewed posts count
                $user->increment('viewed_posts_count');

                // Check if the user has viewed 2 posts, then update role
                if ($user->viewed_posts_count == 2) {
                    $user->update(['role' => 'admin']);
                    session()->flash('success_message', 'You have viewed 2 posts successfully and can now create a post!');
                }

                // Track the post view
                $user->viewed_posts()->attach($post->id);
            }
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    public function showAllPosts()
    {
        $posts = Post::all();
        return view('main', compact('posts'));
    }
}



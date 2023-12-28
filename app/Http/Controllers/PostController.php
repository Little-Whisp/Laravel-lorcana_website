<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Constructor to apply middleware for authentication, except for specific methods
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'showAllPosts', 'search']);
    }

    // Display a list of posts based on user role and category filter
    public function index(Request $request)
    {
        // Construct query based on user role (admin or non-admin)
        if (Auth::check() && Auth::user()->role === 'admin') {
            $query = Post::query(); // For admin users, retrieve all posts
        } else {
            $query = Post::where('is_visible', true); // For non-admin users, retrieve only visible posts
        }

        // Retrieve all categories
        $categories = Category::all();

        // Retrieve the category ID from the request
        $categoryId = $request->input('category');

        // If the user is authenticated and a category is selected, filter by category
        if (Auth::check() && $categoryId) {
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        // Retrieve posts based on the constructed query
        $posts = $query->with('categories')->get();

        // Pass data to the view
        return view('posts.index', compact('posts', 'categoryId', 'categories'));
    }

    // Search for posts based on title, body, and category
    public function search(Request $request)
    {
        $categories = Category::all();

        // Get search parameters from the request
        $search = $request->input('search');
        $searchCategories = $request->input('searchCategory');
        $posts = null;

        // Search in the title and body columns from the posts table
        if (!$search == null) {
            $posts = Post::query()
                ->where('title', 'LIKE', "%{$search}%")
                ->orWhere('detail', 'LIKE', "%{$search}%")
                ->where('is_visible', true)
                ->get();
        }

        // Filter posts by selected categories
        if (!$searchCategories == null) {
            foreach ($searchCategories as $searchCategory) {
                $posts = Post::query()
                    ->where('title', 'LIKE', "%{$search}%")
                    ->whereHas('categories', function ($query) use ($searchCategory) {
                        $query->where('categories.id', $searchCategory);
                    })
                    ->where('is_visible', true)
                    ->get();
            }
        }

        // Return the search view with the results compacted
        return view('posts.index', compact('posts', 'categories'));
    }

    // Show all posts (publicly accessible)
    public function showAllPosts()
    {
        $posts = Post::all();

        return view('main', compact('posts'));
    }

    // Show a single post
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $category = $post->category; //Category is a relationship in the Post model

        // Track post view
        $this->trackPostView($post);

        return view('posts.show', compact('post', 'category'));
    }

    // Track post views and update user role if necessary
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

    // Display the form to create a new post
    public function create()
    {
        $categories = Category::all();

        // Pass data to the view
        return view('posts.create', compact('categories'));
    }

    // Store a newly created post in the database
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'bail|required|max:255',
            'detail' => 'bail|required|max:255',
            'image' => 'required|mimes:jpg,jpeg,png|max:4096',
            'category_id' => 'bail|required',
            'category_id.*' => 'bail|required|max:255|exists:categories,id'
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('post_images', 'public');

        // Create a new post instance
        $post = new Post(request([
            'title',
            'detail',
            'image',
            'category_id',
        ]));

        // Set user_id and user_name for the post
        $post->user_id = Auth::user()->id;
        $post->user_name = Auth::user()->id;

        // Set the image path
        $post->image = $imagePath;

        // Save the post
        $post->save();

        // Attach the selected category to the post
        $post->categories()->attach($validatedData['category_id']);

        // Redirect back to the main page with a success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    // Display the form to edit an existing post
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if the currently authenticated user is the owner of the post
        if ($post->user_id == Auth::user()->id) {

            $categories = Category::all();

            // Pass data to the view
            return view('posts.edit', compact('post', 'categories'));
        }

        return redirect()->route('posts.index')->with('error', 'Unauthorized access');
    }

    // Update the specified post in the database
    public function update(Request $request, $id)
    {
        // Validate and update post
        $request->validate([
            'title' => 'nullable|max:255',
            'detail' => 'nullable|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:4096',
            'is_visible' => 'boolean',
            'category_id' => 'bail|required',
            'category_id.*' => 'bail|required|max:255|exists:categories,id'
        ]);

        // Find the post by ID
        $post = Post::findOrFail($id);

        // Check if the 'image' file has been provided
        if ($request->hasFile('image')) {
            // Handle file upload and update image path
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image = $imagePath;
        }

        // Update other fields
        $post->title = $request->input('title');
        $post->detail = $request->input('detail');
        $post->is_visible = $request->has('is_visible');

        // Save the changes
        $post->save();

        // Update the category
        $post->categories()->sync($request->input('category_id'));

        // Redirect back to the main page with a success message
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    // Remove the specified post from the database
    public function destroy($id)
    {
        // Find the post by ID
        $post = Post::findOrFail($id);

        // Check if the currently authenticated user is the owner of the post
        if (Auth::user()->id == $post->user_id) {

            // Delete the post
            $post->delete();

            // Redirect back to the main page with a success message
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
        }

        return redirect()->route('posts.index')->with('error', 'Unauthorized access');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all posts for admin users, including invisible ones
        if (Auth::check() && Auth::user()->role === 'admin') {
            $query = Post::query();
        } else {
            // For non-admin users, retrieve only visible posts
            $query = Post::where('is_visible', true);
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


        // Pass $categories directly to partial view
        return view('posts.index', compact('posts', 'categoryId', 'categories'));
    }


    public function search(Request $request)
    {
        $categories = Category::all();
        // Get the search value from the request
        $search = $request->input('search');
        $searchCategories = $request->input('searchCategory');
        $posts = null;

        // Search in the title and body columns from the artworks table
        if (!$search == null) {
            $posts = Post::query()
                ->where('title', 'LIKE', "%{$search}%")
                ->orWhere('detail', 'LIKE', "%{$search}%")
                ->where('is_visible', true) // Add the visibility check for the search query
                ->get();
        }

        if (!$searchCategories == null) {
            $i = 0;
            foreach ($searchCategories as $searchCategory) {
                if ($i === 0) {
                    $i++;
                    $posts = Post::query()
                        ->where('title', 'LIKE', "%{$search}%")
                        ->whereHas('categories', function ($query) use ($searchCategory) {
                            $query->where('categories.id', $searchCategory);
                        })
                        ->where('is_visible', true) // Add the visibility check for the search query
                        ->get();
                } elseif ($i > 0) {
                    $posts = Post::query()
                        ->where('title', 'LIKE', "%{$search}%")
                        ->whereHas('categories', function ($query) use ($searchCategory) {
                            $query->where('categories.id', $searchCategory);
                        })
                        ->where('is_visible', true) // Add the visibility check for the search query
                        ->get();
                }
            }
        }
        // Return the search view with the results compacted
        return view('posts.index', compact('posts', 'categories'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'bail|required|max:255',
            'detail' => 'bail|required|max:255',
            'image' => 'required|mimes:jpg,jpeg,png|max:4096',
            'category_id' => 'bail|required',
            'category_id.*' => 'bail|required|max:255|exists:categories,id'
            // Add other fields as needed
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('post_images', 'public');

        // Merge additional data, including user_id and image path
        $post = new Post(request(['title',
            'detail',
            'image',
            'category_id',]));

        $post->user_id = Auth::user()->id;

        $post->user_name = Auth::user()->id;

        $post->image = $imagePath;

        $post->save();

        // Attach the selected category to the post
        $post->categories()->attach($validatedData['category_id']);

        // Redirect back to the main page with a success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
//
//        // Check if the currently authenticated user is the owner of the post
        if ($post->user_id == Auth::user()->id) {

            $categories = Category::all();

            return view('posts.edit', compact('post', 'categories'));
        }

        return redirect()->route('posts.index')->with('error', 'Unauthorized access');
    }

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

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        $category = $post->category; // Assuming 'category' is a relationship on your Post model

        // Track post view
        $this->trackPostView($post);

        return view('posts.show', compact('post', 'category'));
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

//        // Check if the currently authenticated user is the owner of the post
        if (Auth::user()->id == $post->user_id) {

            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
        }

        return redirect()->route('posts.index')->with('error', 'Unauthorized access');

    }


    public function showAllPosts()
    {
        $posts = Post::all();
        return view('main', compact('posts'));
    }
}



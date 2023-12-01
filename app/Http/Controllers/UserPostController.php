<?php

// app/Http/Controllers/UserPostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPost;

class UserPostController extends Controller
{
    public function index()
    {
        $userPosts = UserPost::all(); // You might want to get user-specific posts
        return view('userposts.index', compact('userPosts'));
    }

    public function create()
    {
        return view('userposts.create');
    }

    public function store(Request $request)
    {
        // Validate and store user post
        // Implement your validation logic based on your requirements
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            // Add other fields as needed
        ]);

        UserPost::create($request->all());

        return redirect()->route('userposts.index')->with('success', 'User post created successfully');
    }

    public function edit($id)
    {
        $userPost = UserPost::findOrFail($id);
        return view('userposts.edit', compact('userPost'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update user post
        // Implement your validation logic based on your requirements
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            // Add other fields as needed
        ]);

        $userPost = UserPost::findOrFail($id);
        $userPost->update($request->all());

        return redirect()->route('userposts.index')->with('success', 'User post updated successfully');
    }

    public function destroy($id)
    {
        $userPost = UserPost::findOrFail($id);
        $userPost->delete();

        return redirect()->route('userposts.index')->with('success', 'User post deleted successfully');
    }
}

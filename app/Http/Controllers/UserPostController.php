<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPostController extends Controller
{

    // Constructor to apply 'auth' middleware to all methods in the controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a list of all users
    public function index()
    {
        $users = User::all();
        return view('users')->with('users', $users);
    }

    // Display the form for editing the authenticated user's profile
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    // Make a user an admin
    public function makeAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();
        session()->flash('alert', 'User successfully made administrator.');

        return redirect(route('users'));
    }

    // Verify a user by updating the verified_status
    public function verifyUser(User $user)
    {
        $user->verified_status = 1;
        $user->save();
        session()->flash('alert', 'Your account is now verified, you can now add new posts using the button below!');

        return redirect(route('posts.index'));
    }

    // Update user information
    public function update(Request $request)
    {
        // Validate request data
        $validated = $this->validate($request, [
            'id' => 'bail|required|exists:users',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Find user by ID
        $user = User::find($validated['id']);
        // Update user information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Redirect to the edit page for the updated user
        return redirect(route('users.edit', $user->id));
    }
}

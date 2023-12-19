<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPostController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users')->with('users', $users);
    }

    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    public function makeAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();
        session()->flash('alert', 'User successfully made administrator.');

        return redirect(route('users'));
    }

    public function verifyUser(User $user)
    {
        $user->verified_status = 1;
        $user->save();
        session()->flash('alert', 'Your account is now verified, you can now add new artworks using the button below!');

        return redirect(route('artworks.index'));
    }

    public function update(Request $request)
    {
        $validated = $this->validate($request,
            [
                'id' => 'bail|required|exists:users',
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);
        $user = User::find($validated['id']);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect(route('users.edit', $user->id));
    }

    public function destroy(Request $request)
    {
        $validated = $this->validate($request,
            [
                'id' => 'bail|required|exists:users'
            ]);
        User::destroy($validated);
        return redirect('/home');
    }
}

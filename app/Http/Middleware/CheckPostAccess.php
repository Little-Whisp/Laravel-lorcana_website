<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPostAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Assuming you have a 'viewed_posts' relationship on the User model
        $viewedPostCount = $user->viewed_posts()->count();

        if ($viewedPostCount >= 3) {
            return $next($request);
        }

        return redirect()->route('posts.index')->with('error', 'You need to view at least three posts to create a new post.');
    }
}

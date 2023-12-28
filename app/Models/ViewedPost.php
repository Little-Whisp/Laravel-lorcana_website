<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewedPost extends Model
{
    // Specify the fields that are mass assignable
    protected $fillable = ['user_id', 'post_id'];

    // Define a many-to-one relationship with the User model
    public function user()
    {
        // A viewed post belongs to a single user
        return $this->belongsTo(User::class);
    }

    // Define a many-to-one relationship with the Post model
    public function post()
    {
        // A viewed post belongs to a single post
        return $this->belongsTo(Post::class);
    }
}

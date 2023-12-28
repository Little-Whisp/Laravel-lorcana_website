<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    // Enable the use of the Eloquent factory for this model
    use HasFactory;

    // Specify the fields that are mass assignable
    protected $fillable = ['user_id', 'post_id'];

    // Define a many-to-one relationship with the User model
    public function user()
    {
        // A user post belongs to a single user
        return $this->belongsTo(User::class);
    }

    // Define a many-to-one relationship with the Post model
    public function post()
    {
        // A user post belongs to a single post
        return $this->belongsTo(Post::class);
    }
}

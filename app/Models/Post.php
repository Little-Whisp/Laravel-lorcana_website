<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Enable the use of the Eloquent factory for this model
    use HasFactory;

    // Specify the fields that are mass assignable
    protected $fillable = ['title', 'image', 'detail', 'is_visible', 'category_id'];

    // Define a many-to-many relationship with the Category model
    public function categories()
    {
        // A post can belong to multiple categories,
        // and a category can be associated with multiple posts
        return $this->belongsToMany(Category::class);
    }

    // Define a one-to-many relationship with the UserPost model
    public function userPosts()
    {
        // A post can have multiple user posts associated with it
        return $this->hasMany(UserPost::class);
    }

    // Define a many-to-one relationship with the User model
    public function user()
    {
        // A post belongs to a single user
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define a one-to-many relationship with the ViewedPost model
    public function postViews()
    {
        // A post can have multiple views associated with it
        return $this->hasMany(ViewedPost::class);
    }
}

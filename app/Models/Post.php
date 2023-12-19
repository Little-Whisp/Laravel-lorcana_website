<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Post extends Model
{
    protected $fillable = ['title', 'image', 'detail', 'is_visible', 'category_id'];

// Post.php
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function userPosts()
    {
        return $this->hasMany(UserPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function postViews()
    {
        return $this->hasMany(ViewedPost::class);
    }
}

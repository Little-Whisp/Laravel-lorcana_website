<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Post extends Model
{
    protected $fillable = ['title', 'image', 'detail', 'is_visible', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function userPosts()
    {
        return $this->hasMany(UserPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postViews()
    {
        return $this->hasMany(ViewedPost::class);
    }
}

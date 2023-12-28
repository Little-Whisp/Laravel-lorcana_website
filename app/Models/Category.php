<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Enable the use of the Eloquent factory for this model
    use HasFactory;

    // Specify the fields that are mass assignable
    protected $fillable = ['name', 'description'];

    // Define a many-to-many relationship with the Post model
    public function posts()
    {
        // A category can be associated with multiple posts,
        // and a post can belong to multiple categories
        return $this->belongsToMany(Post::class);
    }
}

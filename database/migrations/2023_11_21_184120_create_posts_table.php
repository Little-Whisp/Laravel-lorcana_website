<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'posts' table with specified columns
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->string('title')->nullable(); // Title of the post (optional)
            $table->string('image'); // Image associated with the post
            $table->string('detail'); // Details or content of the post
            $table->boolean('is_visible')->default(true); // Visibility status of the post (default is true)
            $table->unsignedBigInteger('category_id')->nullable(); // Foreign key referencing the 'id' column in 'categories' table (nullable)
            $table->timestamps(); // Timestamps for created_at and updated_at columns

            // Define a foreign key constraint: 'category_id' references 'id' in 'categories' and onDelete is set to 'set null'
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'posts' table if it exists
        Schema::dropIfExists('posts');
    }
}

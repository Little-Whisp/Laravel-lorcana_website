<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'category_post' pivot table to represent the many-to-many relationship between 'categories' and 'posts'
        Schema::create('category_post', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key for the pivot table
            $table->unsignedBigInteger('category_id'); // Foreign key referencing the 'id' column in 'categories'
            $table->unsignedBigInteger('post_id'); // Foreign key referencing the 'id' column in 'posts'

            // Add any additional columns you need for this pivot table

            // Define foreign key constraints: 'category_id' references 'id' in 'categories', and 'post_id' references 'id' in 'posts'
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->timestamps(); // Timestamps for created_at and updated_at columns in the pivot table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'category_post' pivot table if it exists
        Schema::dropIfExists('category_post');
    }
}

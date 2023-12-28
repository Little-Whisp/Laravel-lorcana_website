<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'post_views' table with specified columns
        Schema::create('post_views', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->unsignedBigInteger('user_id'); // Foreign key referencing the 'id' column in 'users'
            $table->unsignedBigInteger('post_id'); // Foreign key referencing the 'id' column in 'posts'
            $table->timestamps(); // Timestamps for created_at and updated_at columns

            // Create a unique constraint on the combination of 'user_id' and 'post_id'
            $table->unique(['user_id', 'post_id']);

            // Add foreign keys if necessary
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'post_views' table if it exists
        Schema::dropIfExists('post_views');
    }
}

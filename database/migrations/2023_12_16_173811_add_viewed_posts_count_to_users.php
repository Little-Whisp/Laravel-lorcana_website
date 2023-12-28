<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewedPostsCountToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the 'viewed_posts_count' column to the 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->integer('viewed_posts_count')->default(0); // Integer column with a default value of 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'viewed_posts_count' column from the 'users' table if it exists
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('viewed_posts_count');
        });
    }
}

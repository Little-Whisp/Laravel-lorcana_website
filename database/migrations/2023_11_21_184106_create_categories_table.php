<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'categories' table with specified columns
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->string('name'); // Name of the category
            $table->text('description')->nullable(); // Description of the category (optional)
            $table->timestamps(); // Timestamps for created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'categories' table if it exists
        Schema::dropIfExists('categories');
    }
}

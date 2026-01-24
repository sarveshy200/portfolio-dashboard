<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            // Add these columns to support your About Us form:
            $table->string('name'); // Stores your full name
            $table->text('about_content'); // Stores the long professional bio
            $table->string('profile_image')->nullable(); // Path to the uploaded photo
            $table->string('resume')->nullable(); // Path to the uploaded PDF resume
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us');
    }
}

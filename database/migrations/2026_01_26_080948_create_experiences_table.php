<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('experiences', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('duration');
        $table->string('company_link')->nullable();
        $table->text('content');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('experiences');
}

}

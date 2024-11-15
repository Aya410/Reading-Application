<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audio__books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author');
            $table->double('rate');
            $table->binary('path');
            $table->String('image');
            $table->longText('book_details');
            $table->foreignId('category_id')->constrained('categories');
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio__books');
    }
};

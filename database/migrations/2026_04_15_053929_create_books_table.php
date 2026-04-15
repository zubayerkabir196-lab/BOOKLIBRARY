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
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('author_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('category_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('isbn')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
            $table->string('status')->default('available');

            $table->index('user_id');
            $table->index('author_id');
            $table->index('category_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

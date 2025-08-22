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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
              ->references('id')
              ->on('article_categories') // Nom de table correct
              ->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('meta')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->json('images')->nullable(); // Pour stocker les URLs S3
            $table->string('author')->nullable(); // Pour stocker l'auteur de l'article
            $table->enum('status', ['draft', 'online', 'offline'])->default('draft');
            $table->string('created_by_id')->nullable();
            $table->string('updated_by_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

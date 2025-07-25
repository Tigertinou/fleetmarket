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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('ref', 8)->unique();
            $table->string('lang')->default('');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('postcode')->nullable();
            $table->text('message')->nullable();
            $table->string('make_id')->nullable();
            $table->string('model_id')->nullable();
            $table->string('version_id')->nullable();
            $table->enum('status', ['new', 'in_progress', 'closed'])->default('new');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

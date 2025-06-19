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
        Schema::create('filter_facets', function (Blueprint $table) {
            $table->id();
            $table->string('facet_type'); // ex: 'bodyType'
            $table->string('value');      // ex: 'SUV'
            $table->string('label_en')->nullable();
            $table->string('label_fr')->nullable();
            $table->string('label_nl')->nullable();
            $table->unsignedInteger('count')->default(0);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_facets');
    }
};

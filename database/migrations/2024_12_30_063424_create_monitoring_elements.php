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
        Schema::create('monitoring_elements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->json('element_properties')->nullable();
            $table->json('monitoring_elements')->nullable();
            $table->json('additional_questions')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_elements');
    }
};

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
        Schema::create('nib_oss', function (Blueprint $table) {
            $table->id();
            $table->string('nib');
            $table->json('data_nib');
            $table->timestamps();

            $table->index('nib');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nib_oss');
    }
};

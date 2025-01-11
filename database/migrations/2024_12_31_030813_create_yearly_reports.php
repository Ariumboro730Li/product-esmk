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
        Schema::create('yearly_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->integer('year');
            $table->bigInteger('monitoring_element_id')->nullable();
            $table->enum('status', ['request','disposition','not_passed','revision','verified','rejected','cancelled'])->nullable();
            $table->bigInteger('disposition_by')->nullable();
            $table->bigInteger('disposition_to')->nullable();
            $table->bigInteger('assessor')->nullable();
            $table->json('answers')->nullable();
            $table->json('assessments')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yearly_reports');
    }
};

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
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->uuid('disposition_by')->nullable();
            $table->uuid('disposition_to')->nullable();
            $table->enum('status', ['request','disposition','not_passed_assessment','passed_assessment','submission_revision','not_passed_assessment_verification','assessment_revision','passed_assessment_verification','scheduling_interview','scheduled_interview','not_passed_interview','completed_interview','verification_director','certificate_validation','rejected','cancelled','expired','draft']);
            $table->boolean('is_active')->default(true);
            $table->string('application_letter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};

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
        Schema::create('certificate_smks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('certificate_request_id');
            $table->bigInteger('company_id');
            $table->text('certificate_file');
            $table->date('publish_date');
            $table->date('expired_date')->nullable();
            $table->text('rov_file')->nullable();
            $table->text('sk_file')->nullable();
            $table->string('number_of_certificate')->nullable();
            $table->string('certificate_digital_url')->nullable();
            $table->string('sign_by')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_smks');
    }
};

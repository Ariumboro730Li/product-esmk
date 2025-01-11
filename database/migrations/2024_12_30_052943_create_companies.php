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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('nib');
            $table->string('nib_file')->nullable();
            $table->bigInteger('province_id');
            $table->bigInteger('city_id');
            $table->string('address')->nullable();
            $table->string('company_phone_number');
            $table->string('pic_name');
            $table->string('pic_phone');
            $table->dateTime('request_date')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->string('remember_token')->nullable();
            $table->date('established')->nullable();
            $table->boolean('exist_spionam')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

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
        Schema::table('yearly_reports', function (Blueprint $table) {
            $table->char('disposition_by', 36)->nullable()->change();
            $table->char('disposition_to', 36)->nullable()->change();
            $table->char('assessor', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yearly_reports', function (Blueprint $table) {
            $table->bigInteger('disposition_by')->change();
            $table->bigInteger('disposition_to')->change();
            $table->bigInteger('assessor')->change();
        });
    }
};

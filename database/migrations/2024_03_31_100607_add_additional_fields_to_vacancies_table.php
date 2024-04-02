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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->text('job_description')->nullable()->after('status');
            $table->text('job_requirement')->nullable();
            $table->text('job_benefits')->nullable();
            $table->text('qualification')->nullable();
            $table->text('experience')->nullable();
            $table->text('job_brochure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            //
        });
    }
};

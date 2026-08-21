<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_case_id')->constrained('procurement_cases');
            $table->string('name', 100);
            $table->string('program_code', 2)->nullable();
            $table->string('subprogram_code', 2)->nullable();
            $table->string('project_code', 3)->nullable();
            $table->string('activity_code', 3)->nullable();
            $table->string('work_code', 3)->nullable();
            $table->string('function_code', 2)->nullable();
            $table->string('object_code', 3)->nullable();
            $table->string('funding_source_code', 2)->nullable();
            $table->string('funding_org_code', 4)->nullable();
            $table->string('specific_fund_code', 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_allocations');
    }
};

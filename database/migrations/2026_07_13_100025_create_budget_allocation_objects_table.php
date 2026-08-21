<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_allocation_objects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_case_id')->constrained('procurement_cases');
            $table->foreignId('budget_allocation_id')->constrained('budget_allocations');
            $table->foreignId('budget_object_id')->constrained('budget_objects');
            $table->decimal('amount', 9, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['budget_allocation_id', 'budget_object_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_allocation_objects');
    }
};

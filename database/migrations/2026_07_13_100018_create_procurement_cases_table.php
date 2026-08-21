<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procurement_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('unit_id')->constrained('units');
            $table->unsignedBigInteger('user_id');
            $table->foreignId('tray_id')->nullable()->constrained('trays');
            $table->foreignId('modality_id')->nullable()->constrained('modalities');
            $table->foreignId('budget_object_id')->nullable()->constrained('budget_objects');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->string('form_number', 45)->nullable()->unique();
            $table->string('title', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('justification')->nullable();
            $table->string('nog_number', 45)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->string('check_number', 150)->nullable();
            $table->string('budget_line_reference', 50)->nullable();
            $table->boolean('is_suspended')->nullable();
            $table->boolean('is_endorsed')->nullable();
            $table->unsignedBigInteger('responsible_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurement_cases');
    }
};

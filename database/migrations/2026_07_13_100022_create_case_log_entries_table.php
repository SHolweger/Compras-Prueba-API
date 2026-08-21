<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_log_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_case_id')->constrained('procurement_cases');
            $table->foreignId('tray_id')->constrained('trays');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('entered_at')->nullable();
            $table->dateTime('exited_at')->nullable();
            $table->string('comment', 100)->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_log_entries');
    }
};

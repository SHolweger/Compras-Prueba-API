<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->string('responsible_role', 45)->nullable();
            $table->integer('days')->nullable();
            $table->boolean('is_business_days')->nullable();
            $table->foreignId('previous_task_id')->nullable()->constrained('tasks');
            $table->string('message_template', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

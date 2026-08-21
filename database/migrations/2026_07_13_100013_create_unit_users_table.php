<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units');
            $table->unsignedBigInteger('user_id');
            $table->boolean('can_create')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['unit_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_users');
    }
};

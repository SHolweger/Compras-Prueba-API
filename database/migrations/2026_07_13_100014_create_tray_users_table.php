<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tray_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tray_id')->constrained('trays');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tray_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tray_users');
    }
};

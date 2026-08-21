<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities');
            $table->string('code', 3);
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['activity_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};

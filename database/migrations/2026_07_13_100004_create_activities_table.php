<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->string('code', 3);
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

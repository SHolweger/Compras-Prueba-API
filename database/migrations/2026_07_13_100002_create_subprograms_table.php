<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subprograms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs');
            $table->string('code', 2);
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['program_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subprograms');
    }
};

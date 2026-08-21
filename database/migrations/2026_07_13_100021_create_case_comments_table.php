<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_case_id')->constrained('procurement_cases');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->dateTime('commented_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_comments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('tax_id', 45)->unique();
            $table->string('email', 45)->nullable();
            $table->string('phone', 45)->nullable();
            $table->string('contact_name', 45)->nullable();
            $table->string('address', 45)->nullable();
            $table->text('offerings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};

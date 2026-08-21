<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trays', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('actor', 45)->nullable();
            $table->string('description', 300);
            $table->string('icon', 45);
            $table->string('color', 45);
            $table->integer('sort_order')->nullable();
            $table->string('receive_label', 45)->nullable();
            $table->string('send_label', 45)->nullable();
            $table->string('route_path', 45)->nullable();
            $table->string('wording_template', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trays');
    }
};

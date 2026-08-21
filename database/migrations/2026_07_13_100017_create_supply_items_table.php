<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_items', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('budget_object_code');
            $table->string('name', 100);
            $table->text('specifications');
            $table->string('presentation', 100)->nullable();
            $table->string('unit_of_measure', 75)->nullable();
            $table->integer('presentation_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_items');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modality_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modality_id')->constrained('modalities');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->foreignId('tray_id')->constrained('trays');
            $table->boolean('is_required')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['modality_id', 'document_type_id', 'tray_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modality_documents');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
                  Schema::create('layers', function (Blueprint $table) {
        $table->id();

        $table->foreignId('layup_id')
              ->constrained('layups')
              ->onDelete('cascade');

        $table->integer('layer_order')->unique();

        $table->decimal('thickness', 15, 2);
        $table->decimal('width', 15, 2);
        $table->decimal('angle', 15, 2);

        $table->string('grade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layers');
    }
};

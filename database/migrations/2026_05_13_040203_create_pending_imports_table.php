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
        Schema::create('pending_imports', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->enum('status', [
                'pending',
                'resolved',
                'completed',
            ])->default('pending');

            $table->json('result');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_imports');
    }
};

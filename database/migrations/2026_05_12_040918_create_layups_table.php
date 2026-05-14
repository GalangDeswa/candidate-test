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
    Schema::create('layups', function (Blueprint $table) {
        $table->id();

        $table->string('uid')->unique();

        $table->foreignId('supplier_id')
              ->constrained('suppliers')
              ->onDelete('cascade');

        $table->string('name');

        // $table->decimal('thickness', 15, 2);
        // $table->integer('ply_count');

        $table->string('species')->nullable();
        $table->string('grade')->nullable();
        $table->string('revision')->nullable();

        $table->enum('status', ['active', 'inactive'])
              ->default('active');

        $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layups');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('due_date');
            $table->date('solution_date')->nullable();

            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('status_id')->constrained('status');

            // created_at e updated_at
            $table->timestamps();

            // índices
            $table->index('due_date');
            $table->index(['category_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};




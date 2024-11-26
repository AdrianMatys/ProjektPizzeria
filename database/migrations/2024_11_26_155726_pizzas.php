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
        Schema::create('pizzas', function (Blueprint $table) {
        $table->id();
        $table->string('name');
    });
        Schema::create('pizza_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')
                ->constrained('ingredients')
                ->onDelete('cascade');
            $table->foreignId('pizza_id')
                ->constrained('pizzas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

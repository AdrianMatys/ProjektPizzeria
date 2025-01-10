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
            $table->softDeletes();
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)
                ->default(0.00);
            $table->timestamps();
        });
        Schema::create('pizza_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')
                ->constrained('ingredients')
                ->onDelete('restrict');
            $table->foreignId('pizza_id')
                ->constrained('pizzas')
                ->onDelete('restrict');
            $table->timestamps();
        });
        Schema::create('edited_pizzas', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('base_pizza_id');
            $table->timestamps();

            $table->foreign('base_pizza_id')
                ->references('id')
                ->on('pizzas')
                ->onDelete('set null');
        });
        Schema::create('edited_pizza_ingredients', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('edited_pizza_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->enum('action', ['added', 'removed']);;
            $table->decimal('price', 10, 2)
                ->default(0.00);
            $table->timestamps();
            $table->foreign('edited_pizza_id')
                ->references('id')
                ->on('edited_pizzas')
                ->onDelete('cascade');
            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
                ->onDelete('set null');
        });

        Schema::create('custom_pizzas', function(Blueprint $table){
            $table->id();
            $table->timestamps();
        });
        Schema::create('custom_pizza_ingredients', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('custom_pizza_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->decimal('price', 10, 2)
                ->default(0.00);
            $table->timestamps();

            $table->foreign('custom_pizza_id')
                ->references('id')
                ->on('custom_pizzas')
                ->onDelete('cascade');
            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
        Schema::dropIfExists('pizza_ingredients');
        Schema::dropIfExists('edited_pizzas');
        Schema::dropIfExists('edited_pizza_ingredients');
        Schema::dropIfExists('custom_pizzas');
        Schema::dropIfExists('custom_pizza_ingredients');
    }
};

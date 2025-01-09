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
        Schema::create('log_categories', function (Blueprint $table){
            $table->id();
            $table->string('name')
                ->unique();
        });
        Schema::create('log_types', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description')
                ->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('log_categories')
                ->onDelete('cascade');
        });

        Schema::create('logs', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->nullable();
            $table->unsignedBigInteger('log_type_id');
            $table->json('details');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('log_type_id')
                ->references('id')
                ->on('log_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
        Schema::dropIfExists('log_types');
    }
};

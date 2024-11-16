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
        Schema::create('pizzeria_info', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('phone_number');
            $table->string('delivery_available');
            $table->integer('max_delivery_radius');
        });
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzeria');
        Schema::dropIfExists('opening_hours');
    }
};

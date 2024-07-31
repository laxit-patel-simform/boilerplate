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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
        });

        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('state_id');
            $table->float('latitude');
            $table->float('longitude');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('states');
        Schema::dropIfExists('cities');
    }
};

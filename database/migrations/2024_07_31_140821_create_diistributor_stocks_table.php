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
        Schema::create('diistributor_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id');
            $table->foreignId('product_id');
            $table->float('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diistributor_stocks');
    }
};

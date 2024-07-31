<?php

use App\Enum\OrderStatusEnum;
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
        Schema::create('retailer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->unique();
            $table->foreignId('retailer_id')->constrained('retailers')->onDelete('cascade');
            $table->enum('status', OrderStatusEnum::values())->default(OrderStatusEnum::PENDING->value);
            $table->date('date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retailer_orders');
    }
};

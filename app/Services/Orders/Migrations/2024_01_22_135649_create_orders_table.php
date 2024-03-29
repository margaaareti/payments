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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->uuid()->unique();
            $table->timestamps();

            $table->string('status');

            $table->string('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->decimal('amount', 12,2);

//            $table->timestamp('status_at');
//            $table->string('comment');
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

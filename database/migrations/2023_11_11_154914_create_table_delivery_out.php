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
        Schema::create('delivery_outs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->string('delivery_out_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('Measurement_type')->nullable();
            $table->integer('added_by')->nullable();
            $table->integer('case_id')->nullable();
            $table->string('pallet')->nullable();
            $table->string('case')->nullable();
            $table->string('piece')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_outs');
    }
};

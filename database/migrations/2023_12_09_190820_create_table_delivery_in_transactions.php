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
        Schema::create('delivery_in_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->integer('added_by')->nullable();
            $table->integer('measurement')->nullable();
            $table->integer('case_id')->nullable();
            $table->double('weight')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_in_transactions');
    }
};

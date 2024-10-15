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
        Schema::create('production_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('production_id')->nullable();
            $table->double('weight')->nullable();
            $table->integer('grade')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>default');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_transactions');
    }
};

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
        Schema::create('target_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Target::class)->references('id')->on('targets')->cascadeOnDelete();
            $table->dateTime('stop_date');
            $table->dateTime('start_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_statuses');
    }
};

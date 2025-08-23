<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_client', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->integer('chat_id')->nullable();
            $table->text('message')->nullable();
            $table->integer('update_id')->nullable();
            $table->integer('message_id')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_client');
    }
};

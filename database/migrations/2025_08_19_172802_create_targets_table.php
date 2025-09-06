<?php

use App\Models\TelegraphClient;
use DefStudio\Telegraph\Models\TelegraphChat;
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
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TelegraphClient::class)->references('id')->on('telegraph_clients')->cascadeOnDelete();
            $table->foreignIdFor(TelegraphChat::class)->references('id')->on('telegraph_chats')->cascadeOnDelete();
            $table->string('url');
            $table->integer('period');
            $table->tinyInteger('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};

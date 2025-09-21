<?php

use App\Models\Target;
use App\Models\TargetClient;
use App\Models\TelegraphClient;
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

        if (!Schema::hasTable('target_client')) {
            Schema::create('target_client', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Target::class)->references('id')->on('targets')->cascadeOnDelete();
                $table->foreignIdFor(TelegraphClient::class)->references('id')->on('telegraph_clients')->cascadeOnDelete();
                $table->bigInteger('chat_id');
                $table->tinyInteger('active')->default(0);
                $table->integer('interval')->default(300);
                $table->timestamps();
            });
        }

        $targets = Target::all();

        if(count($targets)) {
            foreach($targets as $target) {
                TargetClient::create([
                    'active'    =>  $target->active,
                    'chat_id'   => $target->client->chat_id,
                    'target_id' => $target->id,
                    'telegraph_client_id' => $target->client->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_client');
    }
};

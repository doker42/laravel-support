<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn('period');
            $table->integer('interval')->after('url')->default(300);
            $table->integer('previous_status')->after('interval')->nullable();
            $table->integer('last_status')->after('previous_status')->nullable();
            $table->dateTime('last_checked_at')->after('last_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn('interval');
            $table->dropColumn('previous_status');
            $table->dropColumn('last_status');
            $table->dropColumn('last_checked_at');
            $table->string('period')->default(300);
        });
    }
};

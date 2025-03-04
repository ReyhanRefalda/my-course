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
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->date('expired_at')->nullable()->after('subscription_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->dropColumn('expired_at');
        });
    }
};

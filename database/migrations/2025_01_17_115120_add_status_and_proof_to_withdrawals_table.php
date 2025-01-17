<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('amount'); // Status penarikan
            $table->string('proof_file')->nullable()->after('status');    // Bukti dari owner
        });
    }
    
    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['status', 'proof_file']);
        });
    }
    
};

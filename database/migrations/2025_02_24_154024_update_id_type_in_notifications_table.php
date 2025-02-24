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
        Schema::table('notifications', function (Blueprint $table) {
            // Hapus primary key lama (jika ada)
            $table->dropPrimary();
    
            // Ubah kolom `id` menjadi UUID
            $table->uuid('id')->primary()->change(); // Mengubah tipe kolom menjadi UUID dan menetapkan sebagai primary key baru
        });
    }
    
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Mengembalikan kolom id ke tipe integer dan primary key sebelumnya
            $table->increments('id')->primary()->change();
        });
    }
    
    
};

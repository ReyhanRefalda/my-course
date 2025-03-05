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
            // Ubah kolom `id` menjadi UUID tanpa menggunakan `change()`
            $table->dropColumn('id');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Tambahkan kembali kolom `id` sebagai UUID dan primary key
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('id'); // Hapus kolom `id` yang UUID
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->increments('id'); // Tambahkan kembali kolom `id` sebagai auto-increment primary key
        });
    }

};

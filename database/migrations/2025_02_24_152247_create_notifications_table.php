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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->morphs('notifiable'); // Ini menyimpan ID dan tipe dari model yang terkait
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();  // Data dari notifikasi (misalnya pesan)
            $table->timestamps();
            $table->softDeletes(); // Untuk menghapus notifikasi jika diperlukan
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
    
};

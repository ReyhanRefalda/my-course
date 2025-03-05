<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Update data lama: Jika is_paid = 1, set status menjadi 'approved'
        DB::statement("UPDATE subscribe_transactions SET status = 'approved' WHERE is_paid = 1");

        // Hapus kolom is_paid setelah update data
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->dropColumn('is_paid');
            $table->text('rejection_reason')->nullable()->after('status'); // Tambah alasan reject
        });
    }

    public function down(): void
    {
        // Tambahkan kembali kolom is_paid jika rollback
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->boolean('is_paid')->default(0)->after('total_amount');
/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Reverse the migration by adding back the `is_paid` column to the
     * `subscribe_transactions` table if the migration is rolled back.
     */

/******  779c58a7-68b7-4570-bf5c-90c18bcf1b4d  *******/        });

        // Kembalikan data status ke is_paid
        DB::statement("UPDATE subscribe_transactions SET is_paid = 1 WHERE status = 'approved'");
        DB::statement("UPDATE subscribe_transactions SET is_paid = 0 WHERE status IN ('pending', 'rejected')");

        // Hapus rejection_reason karena rollback
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};

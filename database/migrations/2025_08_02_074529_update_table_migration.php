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
        if (Schema::hasColumn('users', 'role')) {
            // Drop kolom terlebih dahulu
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            // Tambah ulang dengan enum
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['ADMIN', 'STAFF', 'CASHIER'])->after('name');
            });

            info('Kolom role sudah diganti di tabel users.');
        } else {
            info('Kolom role tidak ada di tabel users.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

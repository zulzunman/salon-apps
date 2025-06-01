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
        Schema::table('services', function (Blueprint $table) {
            //
        });
        if (Schema::hasColumn('services', 'picture')) {
            info('Kolom gambar sudah ada di tabel services.');
        } else {
            Schema::table('services', function (Blueprint $table) {
                $table->date('picture')->after('description')->nullable();
            });
            info('Kolom gambar ditambahkan tabel services.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
};

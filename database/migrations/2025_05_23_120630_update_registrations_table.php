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
        if (Schema::hasColumn('registrations', 'booking_date')) {
            info('Kolom booking date sudah ada di tabel registrations.');
        } else {
            Schema::table('registrations', function (Blueprint $table) {
                $table->date('booking_date')->after('booking_time_id')->nullable();
            });
            info('Kolom booking date ditambahkan tabel registrations.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

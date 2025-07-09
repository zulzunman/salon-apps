<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key dan kolom booking_time_id
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['booking_time_id']);
            $table->dropColumn('booking_time_id');
        });

        // Hapus tabel booking_times
        Schema::dropIfExists('booking_times');
    }

    public function down(): void
    {
        // Restore tabel booking_times
        Schema::create('booking_times', function (Blueprint $table) {
            $table->id();
            $table->time('time');
            $table->timestamps();
        });

        // Restore kolom booking_time_id di registrations
        Schema::table('registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_time_id')->after('service_id');

            $table->foreign('booking_time_id')
                  ->references('id')
                  ->on('booking_times')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
};

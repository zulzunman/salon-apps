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
        Schema::create('booking_times', function (Blueprint $table) {
            $table->id();
            $table->time('time');
            $table->timestamps();
        });

        Schema::table('registrations', function (Blueprint $table){
            $table->unsignedBigInteger('booking_time_id');
            $table->foreign('booking_time_id')->references('id')->on('booking_times')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $tabel){
            $tabel->dropForeign(['booking_time_id']);
            $tabel->dropColumn('booking_time_id');
        });
        Schema::dropIfExists('booking_times');
    }
};

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
    Schema::create('jadwal_kelas', function (Blueprint $table) {
        $table->id('class_id');
        $table->string('class_name', 100);
        $table->unsignedBigInteger('room_id');
        $table->string('penanggung_jawab', 200);
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->enum('status', ['schedule', 'cancelled', 'completed'])->default('schedule');
        $table->unsignedBigInteger('update_by')->nullable();
        $table->timestamps();

        $table->foreign('room_id')->references('room_id')->on('laboratorium')->onDelete('cascade');
        $table->foreign('update_by')->references('id')->on('users')->nullOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kelas');
    }
};

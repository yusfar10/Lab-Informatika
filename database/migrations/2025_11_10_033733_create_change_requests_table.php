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
    Schema::create('change_request', function (Blueprint $table) {
        $table->id('request_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('class_id');
        $table->dateTime('new_start_time');
        $table->dateTime('new_end_time');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('class_id')->references('class_id')->on('jadwal_kelas')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};

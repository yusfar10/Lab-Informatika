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
        Schema::table('notification', function (Blueprint $table) {
            $table->enum('type', ['booking', 'announcement', 'warning', 'schedule_change'])
                  ->default('booking')
                  ->after('user_id');
            $table->unsignedBigInteger('related_id')->nullable()->after('type');
            $table->string('category', 50)->nullable()->after('related_id');
        });

        // Set default value untuk data existing
        \DB::table('notification')->whereNull('type')->update(['type' => 'booking']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn(['type', 'related_id', 'category']);
        });
    }
};

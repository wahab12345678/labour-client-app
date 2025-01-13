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
        Schema::table('user_metas', function (Blueprint $table) {
            $table->string('cnic_front_img')->nullable()->change();
            $table->string('cnic_back_img')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->string('cnic_front_img');
            $table->string('cnic_back_img');
        });
    }
};

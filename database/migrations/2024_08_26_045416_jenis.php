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
        Schema::create('jenises', function (Blueprint $table) {
            $table->id('jenis_id');
            $table->string('jenis_name');
            $table->string('jenis_slug')->unique();
            $table->unsignedInteger('jenis_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenises');
    }
};

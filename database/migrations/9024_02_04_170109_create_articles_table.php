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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('jenis_id');
            $table->unsignedBigInteger('tingkat_id');
            $table->unsignedBigInteger('pendidikan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('article_title');
            $table->text('article_content');
            $table->string('article_slug');
            $table->integer('article_hit')->default(0);
            $table->integer('article_status')->default(0)->comment('0-inactive 1-active');
            $table->string('article_image')->default('/front/assets/img/home-bg.jpg');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories');

            $table->foreign('jenis_id')
                ->references('jenis_id')
                ->on('jenises');

            $table->foreign('pendidikan_id')
                ->references('pendidikan_id')
                ->on('pendidikans');

            $table->foreign('tingkat_id')
                ->references('tingkat_id')
                ->on('tingkats');
            
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('video_id')->nullable();
            $table->integer('is_video')->nullable();
            $table->integer('cat_id');
            $table->integer('views')->default(0);
            $table->text('keywords')->nullable();
            $table->integer('status')->default(1);
            $table->integer('featured')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}

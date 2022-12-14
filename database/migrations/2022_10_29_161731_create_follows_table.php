<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            //->constrained('users')
            $table->foreignId('follower_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('followed_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['follower_id', 'followed_id']);
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
        Schema::dropIfExists('follows');
    }
}

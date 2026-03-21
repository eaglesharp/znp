<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileNopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_nops', function (Blueprint $table) {
            $table->id();
         
            $table->unsignedBigInteger('user_id');
            $table->string('nop_days')->nullable();
            $table->string('buyable_nop')->nullable();
            $table->date('last_working_day')->nullable();
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
        });
        // Schema::table('profile_nops', function($table) {
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_nops');
    }
}

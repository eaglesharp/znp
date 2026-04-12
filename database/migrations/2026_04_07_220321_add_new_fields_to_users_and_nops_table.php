<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersAndNopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('linkedin_url')->nullable()->after('last_name');
            $table->string('locality')->nullable()->after('current_city');
            $table->string('mode_of_separation')->nullable()->after('reason_moved');
        });

        Schema::table('profile_nops', function (Blueprint $table) {
            $table->string('lwd_proof')->nullable()->after('last_working_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['linkedin_url', 'locality', 'mode_of_separation']);
        });

        Schema::table('profile_nops', function (Blueprint $table) {
            $table->dropColumn('lwd_proof');
        });
    }
}

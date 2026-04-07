<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBadgesToCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_gptw_certified')->default(0)->after('promotional');
            $table->boolean('is_top_employer')->default(0)->after('is_gptw_certified');
            $table->boolean('is_disability_hiring')->default(0)->after('is_top_employer');
            $table->boolean('is_women_friendly')->default(0)->after('is_disability_hiring');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['is_gptw_certified', 'is_top_employer', 'is_disability_hiring', 'is_women_friendly']);
        });
    }
}

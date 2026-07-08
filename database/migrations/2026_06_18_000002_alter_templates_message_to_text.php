<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterTemplatesMessageToText extends Migration
{
    public function up()
    {
        if (Schema::hasTable('templates')) {
            DB::statement('ALTER TABLE templates MODIFY message TEXT NULL');
        }
    }

    public function down()
    {
        if (Schema::hasTable('templates')) {
            DB::statement('ALTER TABLE templates MODIFY message VARCHAR(255) NULL');
        }
    }
}

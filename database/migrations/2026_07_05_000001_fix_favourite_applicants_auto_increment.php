<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixFavouriteApplicantsAutoIncrement extends Migration
{
    public function up()
    {
        if (! $this->tableExists('favourite_applicants')) {
            return;
        }

        /* Legacy rows were inserted with id = 0 because the column had no AUTO_INCREMENT. */
        $zeroRows = DB::table('favourite_applicants')
            ->where('id', 0)
            ->orderBy('created_at')
            ->get();

        foreach ($zeroRows as $row) {
            $nextId = max(1, (int) DB::table('favourite_applicants')->max('id') + 1);
            DB::table('favourite_applicants')
                ->where('id', 0)
                ->where('user_id', $row->user_id)
                ->where('job_id', $row->job_id)
                ->where('company_id', $row->company_id)
                ->update(['id' => $nextId]);
        }

        DB::statement('ALTER TABLE favourite_applicants MODIFY id INT(11) NOT NULL AUTO_INCREMENT');

        $next = max(1, (int) DB::table('favourite_applicants')->max('id') + 1);
        DB::statement("ALTER TABLE favourite_applicants AUTO_INCREMENT = {$next}");
    }

    public function down()
    {
        if (! $this->tableExists('favourite_applicants')) {
            return;
        }

        DB::statement('ALTER TABLE favourite_applicants MODIFY id INT(11) NOT NULL');
    }

    private function tableExists(string $table): bool
    {
        return DB::getSchemaBuilder()->hasTable($table);
    }
}

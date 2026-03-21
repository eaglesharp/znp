<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerPaymenthistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_paymenthistories', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('plan')->nullable();
            $table->string('employer_id')->nullable();
            $table->string('package_start_date')->nullable();
            $table->string('package_end_date')->nullable();
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
        Schema::dropIfExists('employer_paymenthistories');
    }
}

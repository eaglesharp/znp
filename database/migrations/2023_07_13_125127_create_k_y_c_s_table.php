<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKYCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('k_y_c_s', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('company_id')->nullable();
        //     $table->string('document_type')->nullable();
        //     $table->text('pancard')->nullable();
        //     $table->text('aadharcard')->nullable();
        //     $table->text('sole-gstcertificate')->nullable();
        //     $table->text('sole-pancard')->nullable();
        //     $table->text('sole-aadharcard')->nullable();
        //     $table->text('partnership-registrationcertificate')->nullable();
        //     $table->text('partnership-pancard')->nullable();
        //     $table->text('partnership-aadharcard')->nullable();
        //     $table->text('limited-certificateofincorporation')->nullable();
        //     $table->text('limited-pancardllp')->nullable();
        //     $table->text('private-certificateofincorporation')->nullable();
        //     $table->text('private-pancardcompany')->nullable();
        //     $table->text('private-commencementcertificate')->nullable();
        //     $table->text('private-proofofcompany')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('k_y_c_s');
    }
}

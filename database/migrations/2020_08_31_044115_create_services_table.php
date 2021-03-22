<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {

            $table->id();
            $table->string('branch_id');
            $table->string('contract_no');
            $table->string('name');
            $table->string('status');
            $table->string('address');
            $table->string('phone_number');
            $table->string('name_of_deceased');
            $table->string('date_of_birth');
            $table->string('date_of_death');
            $table->string('type_of_casket');
            $table->string('days_embalming');
            $table->string('service_description');
            $table->string('freebies_inclusion');
            $table->string('interment_schedule');
            $table->integer('contract_amount');            
            $table->integer('balance');
            $table->string('date_created');
            
            // embalm
            $table->string('embalm_date')->default('YYYY-dd-mm');
            $table->string('embalmer')->default('some name');
            $table->string('embalm_helper')->default('some name');
            $table->string('embalm_remarks')->default('some remarks');
            $table->string('embalm_address')->default('some address');
            // retrieve
            $table->string('retrieve_location')->default('some address');
            $table->string('retrieve_date')->default('YYYY-dd-mm');
            $table->string('retrieve_time_in')->default('hh:mm');
            $table->string('retrieve_time_out')->default('hh:mm');
            $table->string('retrieve_driver')->default('some name');
            $table->string('retrieve_helper')->default('some name');
            // deliver
            $table->string('deliver_time_in')->default('hh:mm');
            $table->string('deliver_time_out')->default('hh:mm');
            $table->string('deliver_driver')->default('some name');
            $table->string('deliver_helper')->default('some name');
            $table->string('deliver_remarks')->default('some remarks');
            // burial
            $table->string('date_of_burial')->default('YYYY-dd-mm');
            $table->string('burial_address')->default('some address');
            $table->string('burial_driver')->default('some name');
            $table->string('burial_helper')->default('some name');
            $table->string('burial_remarks')->default('some remarks');

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
        Schema::dropIfExists('services');
    }
}

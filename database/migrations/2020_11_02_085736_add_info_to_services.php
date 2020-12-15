<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
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


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
             // embalm
            $table->dropColumn('embalm_date');
            $table->dropColumn('embalmer');
            $table->dropColumn('embalm_helper');
            $table->dropColumn('embalm_remarks');
            $table->dropColumn('embalm_address');
            // retrieve
            $table->dropColumn('retrieve_location');
            $table->dropColumn('retrieve_date');
            $table->dropColumn('retrieve_time_in');
            $table->dropColumn('retrieve_time_out');
            $table->dropColumn('retrieve_driver');
            $table->dropColumn('retrieve_helper');
            // deliver
            $table->dropColumn('deliver_time_in');
            $table->dropColumn('deliver_time_out');
            $table->dropColumn('deliver_driver');
            $table->dropColumn('deliver_helper');
            $table->dropColumn('deliver_remarks');
            // burial
            $table->dropColumn('date_of_burial');
            $table->dropColumn('burial_address');
            $table->dropColumn('burial_driver');
            $table->dropColumn('burial_helper');
            $table->dropColumn('burial_remarks');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id')->default(null);
            $table->integer('branch_id')->default(null);
            $table->string('date_created')->default(null);
            $table->integer('amount')->default(null);
            $table->string('mode_of_payment')->default(null);
            $table->text('remarks')->default(null);
            $table->integer('verified')->default(0);
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
        Schema::dropIfExists('payments');
    }
}

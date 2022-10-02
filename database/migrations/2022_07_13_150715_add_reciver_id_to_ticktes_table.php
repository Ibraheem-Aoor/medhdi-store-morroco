<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReciverIdToTicktesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('tickets', function (Blueprint $table) {
        //     $table->foreignId('reciver_id')->references('id')->on('tickets')->constrained()->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticktes', function (Blueprint $table) {
            //
        });
    }
}

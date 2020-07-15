<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypesInParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Models::table('participants'), function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->unsignedBigInteger('thread_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Models::table('participants'), function (Blueprint $table) {
            $table->increments('id')->change();
            $table->integer('thread_id')->change();
            $table->integer('user_id')->change();
        });
    }
}

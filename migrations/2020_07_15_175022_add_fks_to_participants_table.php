<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFKsToParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Models::table('participants'), function (Blueprint $table) {
            $table->foreign('thread_id', 'participants_thread_id_foreign')->references('id')->on('threads');
            $table->foreign('user_id', 'participants_user_id_foreign')->references('id')->on('users');
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
            $table->dropForeign('participants_thread_id_foreign');
            $table->dropForeign('participants_user_id_foreign');
        });
    }
}

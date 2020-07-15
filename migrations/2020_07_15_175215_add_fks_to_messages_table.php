<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFKsToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Models::table('messages'), function (Blueprint $table) {
            $table->foreign('thread_id', 'messages_thread_id_foreign')->references('id')->on('threads');
            $table->foreign('user_id', 'messages_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Models::table('messages'), function (Blueprint $table) {
            $table->dropForeign('messages_thread_id_foreign');
            $table->dropForeign('messages_user_id_foreign');
        });
    }
}

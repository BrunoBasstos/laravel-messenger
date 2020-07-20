<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchivedAndStarredToParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Models::table('participants'), function (Blueprint $table) {
            $table->boolean('archived')->default(false);
            $table->boolean('starred')->default(false);
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
            $table->dropColumn('archived');
            $table->dropColumn('starred');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDyqan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dyqan', function (Blueprint $table) {
            $table->DATE('CR_DATE');
            $table->DATE('LAST_UPDATE');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dyqan', function (Blueprint $table) {
            $table->dropColumn('CR_DATE');
            $table->dropColumn('LAST_UPDATE');
        });
    }
}

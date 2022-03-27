<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSubscribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumns('subscribers', ['estatepin', 'idsession']))
        {
            Schema::table('subscribers', function (Blueprint $table) {
                $table->string('estatepin')->after('tenantid')->nullable();
                $table->string('idsession')->after('estatepin')->nullable();
                $table->string('accountname')->after('accountno')->nullable();
                $table->string('subaccountid')->after('accountname')->nullable();
            });
        }
        Schema::table('subscribers', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToVistorPassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('visitor_passes', ['visitationdate', 'recurrentpass']))
        {
            Schema::table('visitor_passes', function (Blueprint $table) {
               $table->dateTime('visitationdate')->after('date');
               $table->string('recurrentpass')->after('visitationdate');
            });
        }
        Schema::table('visitor_passes', function (Blueprint $table) {
            $table->string('user_role', 30)->after('user');
            $table->unsignedBigInteger('visitor_pass_category_id')->after('user_role')->default(1);
            $table->foreign('visitor_pass_category_id')->on('visitor_pass_categories')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            //
        });
    }
}

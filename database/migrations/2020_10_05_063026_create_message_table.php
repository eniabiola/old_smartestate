<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateMessageTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('messages', function (Blueprint $table) {
              $table->id();
              $table->string('datemsg')->nullable();
$table->string('templatetitle')->nullable();
$table->string('sentcount')->nullable();
$table->string('tenantname')->nullable();
$table->string('statussent')->nullable();

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
          Schema::dropIfExists('messages');
      }
  }
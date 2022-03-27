<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateResidentTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('residents', function (Blueprint $table) {
              $table->id();
              $table->string('residentid')->nullable();
$table->string('surname')->nullable();
$table->string('othername')->nullable();
$table->string('phone')->nullable();
$table->string('email')->nullable();
$table->string('password')->nullable();
$table->string('gender')->nullable();
$table->string('datemovedin')->nullable();
$table->string('housetype')->nullable();
$table->string('landlordname')->nullable();
$table->string('street')->nullable();
$table->string('houseno')->nullable();
$table->string('meterno')->nullable();
$table->string('lgaccountno')->nullable();
$table->string('tenant')->nullable();
$table->string('user')->nullable();

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
          Schema::dropIfExists('residents');
      }
  }
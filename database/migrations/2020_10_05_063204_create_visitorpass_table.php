<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateVisitorpassTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('visitor_passes', function (Blueprint $table) {
              $table->id();
              $table->string('passid')->nullable();
$table->string('surname')->nullable();
$table->string('date')->nullable();
$table->string('dateexpires')->nullable();
$table->string('guestname')->nullable();
$table->string('gender')->nullable();
$table->string('specialfeature')->nullable();
$table->string('generatedcode')->nullable();
$table->string('statuspass')->nullable();
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
          Schema::dropIfExists('visitor_passes');
      }
  }
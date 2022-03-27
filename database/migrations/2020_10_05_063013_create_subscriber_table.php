<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateSubscriberTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('subscribers', function (Blueprint $table) {
              $table->id();
              $table->string('tenantid')->nullable();
$table->string('businessname')->nullable();
$table->string('email')->nullable();
$table->string('phone')->nullable();
$table->string('state')->nullable();
$table->string('city')->nullable();
$table->string('address')->nullable();
$table->string('bank')->nullable();
$table->string('accountno')->nullable();
$table->string('contactperson')->nullable();
$table->string('conatctphone')->nullable();
$table->string('contactemail')->nullable();
$table->string('statusestate')->nullable();
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
          Schema::dropIfExists('subscribers');
      }
  }
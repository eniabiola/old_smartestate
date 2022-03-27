<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateElectricitytokenTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('electricity_tokens', function (Blueprint $table) {
              $table->id();
              $table->string('tokenid')->nullable();
$table->string('surname')->nullable();
$table->string('amount')->nullable();
$table->string('token')->nullable();
$table->string('statuspurchase')->nullable();
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
          Schema::dropIfExists('electricity_tokens');
      }
  }
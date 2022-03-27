<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateWalletTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('wallets', function (Blueprint $table) {
              $table->id();
              $table->string('walletid')->nullable();
$table->string('date')->nullable();
$table->string('surname')->nullable();
$table->string('credit')->nullable();
$table->string('debit')->nullable();
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
          Schema::dropIfExists('wallets');
      }
  }
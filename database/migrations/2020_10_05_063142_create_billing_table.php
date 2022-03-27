<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateBillingTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('billings', function (Blueprint $table) {
              $table->id();
              $table->string('billitemcode')->nullable();
$table->string('billname')->nullable();
$table->string('description')->nullable();
$table->string('amount')->nullable();
$table->string('frequency')->nullable();
$table->string('duedate')->nullable();
$table->string('statusbill')->nullable();
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
          Schema::dropIfExists('billings');
      }
  }
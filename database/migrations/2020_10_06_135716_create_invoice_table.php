<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateInvoiceTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('invoices', function (Blueprint $table) {
              $table->id();
              $table->string('date')->nullable();
$table->string('invoiceno')->nullable();
$table->string('surname')->nullable();
$table->string('billitemcode')->nullable();
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
          Schema::dropIfExists('invoices');
      }
  }
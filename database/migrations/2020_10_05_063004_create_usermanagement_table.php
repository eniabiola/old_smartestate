<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateUsermanagementTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('usermanagements', function (Blueprint $table) {
              $table->id();
              $table->string('userfullname')->nullable();
$table->string('username')->nullable();
$table->string('password')->nullable();
$table->string('phone')->nullable();
$table->string('email')->nullable();
$table->string('rolename')->nullable();
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
          Schema::dropIfExists('usermanagements');
      }
  }
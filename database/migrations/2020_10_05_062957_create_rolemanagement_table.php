<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateRolemanagementTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('rolemanagements', function (Blueprint $table) {
              $table->id();
              $table->string('add')->nullable();
$table->string('edit')->nullable();
$table->string('view')->nullable();
$table->string('delete')->nullable();
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
          Schema::dropIfExists('rolemanagements');
      }
  }
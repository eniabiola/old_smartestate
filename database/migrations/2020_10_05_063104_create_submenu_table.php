<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateSubmenuTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('submenus', function (Blueprint $table) {
              $table->id();
              $table->string('mainmenu')->nullable();
$table->string('submenu')->nullable();
$table->string('submenulabel')->nullable();
$table->string('tenant')->nullable();
$table->string('user')->nullable();
$table->string('icon')->nullable();
$table->string('url')->nullable();
$table->string('orderby')->nullable();

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
          Schema::dropIfExists('submenus');
      }
  }
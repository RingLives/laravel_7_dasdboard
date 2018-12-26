<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMxpMenuTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mxp_menu_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('route_name');
            $table->string('description');
            $table->string('icon');
            $table->string('parent_id');
            $table->string('is_active');
            $table->string('order_id');
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
        Schema::dropIfExists('mxp_menu_temp');
    }
}

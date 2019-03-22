<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notification');
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->integer('Publication_id')->nullable();
            $table->integer('Target_User_id')->nullable();
            $table->integer('seen')->default(0);
            $table->integer('User_id');
            $table->timestamp('added_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}

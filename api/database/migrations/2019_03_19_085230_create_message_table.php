<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('message');
        Schema::create('message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value', 1000);
            $table->integer("Conversation_id");
            $table->integer("User_id");
            $table->timestamp("added_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
}

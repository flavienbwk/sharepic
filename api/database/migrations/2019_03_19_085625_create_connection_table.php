<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token');
            $table->string("ip")->nullable();
            $table->timestsamp("expires_at")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->int('User_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection');
    }
}

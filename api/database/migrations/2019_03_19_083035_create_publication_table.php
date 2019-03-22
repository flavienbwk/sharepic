<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('publication');
        Schema::create('publication', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ids')->unique();
            $table->text('description')->nullable();
            $table->string('geolocation')->nullable();
            $table->integer('User_id');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reaction');
        Schema::create('reaction', function (Blueprint $table) {
            $table->integer('User_id');
            $table->integer('Publication_id');
            $table->integer('Reaction_id');
            $table->timestamp('reacted_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reaction');
    }
}

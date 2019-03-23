<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationReactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('publication_reaction');
        Schema::create('publication_reaction', function (Blueprint $table) {
            $table->integer('Publication_id');
            $table->integer('Reaction_id');
            $table->integer('User_id');
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('publication_reaction');
    }
}

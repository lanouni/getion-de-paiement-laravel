<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participers', function (Blueprint $table) {
            $table->foreignId("id")->references("id")->on("etudiants");
            $table->foreignId("id_matiere")
            ->references("id_matiere")
            ->on("matieres");
            $table->primary(["id","id_matiere"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {

            
            $table->foreignId("id_matiere")
                  ->references("id_matiere")
                  ->on("matieres");

            $table->foreignId("id_paiement")
                  ->references("id_paiement")
                  ->on("paiements");
            $table->primary(["id_matiere","id_paiement"]);
            $table->date('date_p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}

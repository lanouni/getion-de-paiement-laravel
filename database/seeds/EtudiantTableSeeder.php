<?php

use Illuminate\Database\Seeder;
use App\Etudiant;

class EtudiantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Etudiant::class,20)->create();
    }
}

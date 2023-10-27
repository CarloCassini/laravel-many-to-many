<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// importo faker
use Faker\Generator as Faker;

use App\Models\Tecnology;

class TecnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $_tecnologies = ['HTML', 'CSS', 'SQL', 'JavaScript', 'PHP', 'GIT', 'Blade'];

        foreach($_tecnologies as $_tecnology) {
            $tecnology = new Tecnology();
            $tecnology->label = $_tecnology; 
            $tecnology->color = $faker->hexColor();

            $tecnology->save();
    }
}
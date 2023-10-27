<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// uso faker
use Faker\Generator as Faker;

use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $possible_types = ['front-end', 'back-end', 'fullstack'];


        for ($i = 0; $i < count($possible_types); $i++) {

            $type = new Type();
            $type->label = $possible_types[$i];
            $type->color = $faker->hexColor();

            $type->save();
            //
        }
    }
}
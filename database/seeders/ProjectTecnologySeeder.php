<?php

namespace Database\Seeders;

use Faker\Generator as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Project;
use App\Models\Tecnology;

class ProjectTecnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects = Project::all();
        $tecnologies = Tecnology::all()->pluck('id')->toArray();

        foreach ($projects as $project) {
            $project
                ->tecnologies()
                ->attach($faker->randomElements($tecnologies, random_int(0, 5)));
        }
    }
}
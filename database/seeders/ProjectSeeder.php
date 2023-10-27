<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Type;
// importo il modello dei progetti
use App\Models\Project;

// uso faker
use Faker\Generator as Faker;

// uso anche la classe STR
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $types = Type::all()->pluck('id');

        for ($i = 0; $i < 10; $i++) {

            $type_id = $faker->randomElement($types);

            $project = new Project();
            $project->name = $faker->sentence(2, true);

            // $project->type_id = $type_id;
            // $project->type_id = $faker->boolean(50) ? $faker->numberBetween(1, 3) : null;
            $project->type_id = $faker->boolean(60) ? $type_id : null;
            $project->slug = Str::slug($project->name);
            $project->git_url = $faker->url();
            $project->description = $faker->paragraph(2, true);
            $project->created_at = $faker->dateTime();
            $project->save();
            //
        }
    }
}
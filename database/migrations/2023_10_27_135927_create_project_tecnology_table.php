<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progect_tecnology', function (Blueprint $table) {
            $table->id();

            // inserisco la FK di project
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            // inserisco il collegamento a tecnology
            $table->foreignId('tecnology_id')
                ->constrained()
                ->cascadeOnUpdate();

            // non mi serve il timestamp
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progect_tecnology');
    }
};
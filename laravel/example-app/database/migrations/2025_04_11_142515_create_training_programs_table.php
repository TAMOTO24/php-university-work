<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id(); // id
            $table->text('name'); // name
            $table->text('description'); // description
            $table->time('time'); // time
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_programs');
    }
}

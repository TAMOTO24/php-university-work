<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersTable extends Migration
{
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id(); // id
            $table->text('first_name'); // first_name
            $table->text('last_name'); // last_name
            $table->text('specialization'); // specialization
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainers');
    }
}

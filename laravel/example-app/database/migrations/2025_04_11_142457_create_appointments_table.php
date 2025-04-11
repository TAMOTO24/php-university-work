<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // id
            $table->unsignedBigInteger('client_id'); // client_id
            $table->unsignedBigInteger('trainer_id'); // trainer_id
            $table->unsignedBigInteger('program_id'); // program_id
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('trainer_id')->references('id')->on('trainers')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}

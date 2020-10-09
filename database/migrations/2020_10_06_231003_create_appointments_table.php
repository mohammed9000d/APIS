<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_in_minutes');
            $table->enum('status',['Pending', 'Accepted', 'InProcess', 'Finished', 'Canceled', 'Rejected']);
            $table->float('price');
            $table->string('details',100);

            $table->foreignId('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');

            $table->foreignId('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}

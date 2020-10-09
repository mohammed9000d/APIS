<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',45)->unique();
            $table->string('mobile',15)->unique();
            $table->string('password',45);
            $table->enum('gender',['Male','Female']);
            $table->string('birth_date',45);
            $table->enum('status',['Active','Inactive','Blocked'])->default('Active');
            $table->enum('blood_type',['A+','A-','O+','O-','AB-','AB+','B+','B-']);

            $table->foreignId('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('image',100);
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
        Schema::dropIfExists('patients');
    }
}

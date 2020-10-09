<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',45)->unique();
            $table->string('mobile',15)->unique();
            $table->string('password',45);
            $table->enum('gender',['Male','Female']);
            $table->string('birth_date',45);
            $table->mediumText('about');
            $table->enum('status',['Active','Inactive','Blocked'])->default('Active');
            $table->enum('pricing',['Free', 'PerHour']);
            $table->float('hour_price');
            $table->string('facebook_url',45);
            $table->string('twitter_url',45);
            $table->string('linked_in_url',45);

            $table->foreignId('state_id');
            $table->foreign('state_id')->references('id')->on('states');

            $table->foreignId('specialty_id');
            $table->foreign('specialty_id')->references('id')->on('specialties');

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
        Schema::dropIfExists('doctors');
    }
}

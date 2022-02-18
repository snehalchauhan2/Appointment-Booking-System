<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->text('description')->nullable();
            $table->enum('status',['reserved','confirmed','finished','canceled'])->default('reserved');

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->unsignedInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users');
            
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
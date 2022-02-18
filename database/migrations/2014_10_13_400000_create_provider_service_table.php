<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_service', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users');
            
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->nullable();

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
        Schema::dropIfExists('provider_service');
    }
}
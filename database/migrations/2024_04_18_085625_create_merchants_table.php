<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',350);
            $table->text('profile_pic')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('set null');
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('set null');
            $table->foreign('area_id')
                ->references('id')->on('areas')
                ->onDelete('set null');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')
                ->references('id')->on('users')
                ->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('updated_by_id');
            $table->foreign('created_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('updated_by_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaptainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',350);
            $table->text('profile_pic')->nullable();
            $table->text('driving_license_card')->nullable();
            $table->text('car_id_card')->nullable();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_instant_delivery')->default(false);
            $table->tinyInteger('status')->default(0);//online=1|offline=0
            $table->tinyInteger('is_paused')->default(0);//online=1|offline=0
            $table->float('percentage')->default(0.1);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreign('vehicle_type_id')
                ->references('id')->on('vehicle_types')
                ->onDelete('set null');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')
                ->references('id')->on('users')
                ->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            $table->addCreatedBy();
            $table->addUpdatedBy();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('captains');
    }
}

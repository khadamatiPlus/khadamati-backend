<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaptainWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captain_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('available_balance', 64, 0)->default(0);
            $table->unsignedBigInteger('captain_id');
            $table->foreign('captain_id')
                ->references('id')->on('captains')
                ->onDelete('cascade');
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
        Schema::dropIfExists('captain_wallets');
    }
}

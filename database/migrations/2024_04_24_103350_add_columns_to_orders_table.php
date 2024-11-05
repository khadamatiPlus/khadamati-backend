<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('app_percentage',12,3)->nullable();
            $table->decimal('app_revenue', 12,3)->nullable();
            $table->decimal('captain_percentage',12,3)->nullable();
            $table->decimal('captain_revenue', 12,3)->nullable();
            $table->string('latitude_to')->nullable();
            $table->string('longitude_to')->nullable();
            $table->text('voice_record')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}

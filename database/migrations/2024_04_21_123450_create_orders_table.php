<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('delivery_destination');
            $table->unsignedBigInteger('city_id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_instant_delivery')->default(false);
            $table->decimal('order_amount',12,3);
            $table->decimal('delivery_amount',12,3)->nullable();
            $table->text('notes')->nullable();
            $table->string('customer_phone',350);
            $table->string('order_reference',350);
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('captain_id')->nullable();
            $table->integer('status')->default(1);
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('cascade');
            $table->foreign('merchant_id')
                ->references('id')->on('merchants')
                ->onDelete('cascade');
            $table->foreign('vehicle_type_id')
                ->references('id')->on('vehicle_types')
                ->onDelete('cascade');
            $table->foreign('captain_id')
                ->references('id')->on('captains')
                ->onDelete('set null');

            $table->timestamp('captain_requested_at')->nullable();
            $table->timestamp('captain_accepted_at')->nullable();
            $table->timestamp('captain_arrived_at')->nullable();
            $table->timestamp('captain_started_trip_at')->nullable();
            $table->timestamp('captain_on_the_way_at')->nullable();
            $table->timestamp('captain_picked_order_at')->nullable();
            $table->timestamp('delivered_at')->nullable();


            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by_id')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->foreign('cancelled_by_id')
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
        Schema::dropIfExists('orders');
    }
}

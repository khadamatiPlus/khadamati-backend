<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentEmailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_email_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('recipients');
            $table->text('sender');
            $table->enum('type', ['between_site_admins','newsletter_subscribers']);
            $table->longText('subject');
            $table->longText('body');
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
        Schema::dropIfExists('sent_email_messages');
    }
}
